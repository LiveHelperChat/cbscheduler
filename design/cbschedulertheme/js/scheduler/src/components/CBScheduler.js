import React, { useEffect, useState, useReducer } from "react";
import axios from "axios";

import PhoneInput from 'react-phone-number-input'
import {useTranslation} from 'react-i18next';

import CancelModule from "./parts/CancelModule";
import ChooseTZModule from "./parts/ChooseTZModule";

const CBScheduler = props => {

    // Attributes lists
    const [days, setDays] = useState([]);
    const [times, setTimes] = useState([]);
    const [subjects, setSubjects] = useState([]);

    // Error messages
    const [errors, setErrors] = useState([]);

    // Error message
    const [error, setError] = useState(null);
    const [error_code, setErrorCode] = useState(null);

    // Single type attribtues
    const [day, setDay] = useState(null);
    const [time, setTime] = useState(null);
    const [timeLiteralValue, setTimeLiteralValue] = useState(null);
    const [dateLiteralValue, setDateLiteralValue] = useState(null);
    const [username, setUsername] = useState((props.username != '' && props.username != null && props.username != 'Visitor' && props.username != 'undefined') ? props.username : null);
    const [subject, setSubject] = useState((props.subject != '' && props.subject != null) ? props.subject : null);
    const [description, setDescription] = useState((props.description != '' && props.description != null) ? props.description : null);
    const [phone, setPhone] = useState((props.phone != '' && props.phone != null) ? props.phone : null);
    const [email, setEmail] = useState((props.email != '' && props.email != null) ? props.email : null);
    const [countries, setCountries] = useState(null);
    const [department, setDepartment] = useState(props.dep_id);
    const [termsOfService, setTermsOfService] = useState(null);


    // logical attributes
    const [isCancelMode, setCancelMode] = useState(false);
    const [isChooseTZMode, setChooseTZMode] = useState(false);
    const [isDisabled, setDisabled] = useState(false);
    const [isSubmitting, setSubmitting] = useState(false);
    const [isScheduled, setScheduled] = useState(false);
    const [cbData, setData] = useState(null);
    const [defaultCountry, setDefaultCountry] = useState(null);
    const [logo, setLogo] = useState(null);
    const [isLoaded, setLoaded] = useState(false);
    const [isTermsAgree, setTermsOfServiceAgree] = useState(false);
    const [attempt, setAttempt] = useState(0);

    const onClose = () => {
        props.ee.emitEvent('endCheduler',[props])
    }

    // Helpers
    const getTzOffset = () => {
        try {
            var tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
            if (tz == 'undefined') { tz = 'UTC'; }
            return tz;
        } catch (e) {
            Date.prototype.stdTimezoneOffset = function() {
                var jan = new Date(this.getFullYear(), 0, 1);
                var jul = new Date(this.getFullYear(), 6, 1);
                return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
            };

            Date.prototype.dst = function() {
                return this.getTimezoneOffset() < this.stdTimezoneOffset();
            };

            var today = new Date();
            var timeZoneOffset = 0;

            if (today.dst()) {
                timeZoneOffset = today.getTimezoneOffset();
            } else {
                timeZoneOffset = today.getTimezoneOffset()-60;
            };

            return (timeZoneOffset/60)*-1;
        }
    };

    // Time Zone handling
    const [timezone, setTimezone] = useState(getTzOffset());

    const getDays = () => {
        axios.get(props.base_path  + "cbscheduler/getdays/(department)/" + department + "/(chat)/" + props.chat_id + "/(hash)/" + props.hash + '/(vid)/'+ props.vid + '/(theme)/'+ props.theme + '?tz=' + timezone ).then(result => {
            setDays(result.data.days);
            setDefaultCountry(result.data.default_country);
            setLogo(result.data.logo);

            if (result.data.username && (username === null || props.chat_id)) {
                setUsername(result.data.username);
            }

            if (result.data.email) {
                setEmail(result.data.email);
            }

            if (result.data.countries) {
                setCountries(result.data.countries);
            }

            if (result.data.terms_of_service) {
                setTermsOfService(result.data.terms_of_service);
            }

            if (department === null) {
                setDepartment(result.data.department);

            }

            setLoaded(true);
        });
    }

    const chooseTimeZone = (e) => {
        setChooseTZMode(!isChooseTZMode);
    }

    const getSubjects = (e) => {
        axios.get(props.base_path  + "cbscheduler/getsubjects/(department)/" + department).then(result => {
            setSubjects(result.data);
        });
    }

    const cancelScheduled = (mode) => {
        setCancelMode(mode);
    }

    const getPostData = () => {
        return {
            'username':username,
            'timezone':timezone,
            'dep_id':department,
            'chat_id':props.chat_id,
            'parent_id':props.parent_id,
            'hash':props.hash,
            'subject':subject,
            'description':description,
            'phone':phone,
            'email':email,
            'day':day,
            'time':time,
            'attempt': attempt,
            'terms_agree': isTermsAgree,
        };
    }

    // User failed hardcore validation
    const goToAgent = () => {
        axios.post(props.base_path  + "cbscheduler/gotoagent", getPostData()).then(result => {
            props.ee.emitEvent('cbscheduler.live_support',[{'chat_id' : props.chat_id, 'fields' : {"Question" : t('fields.verification_failed')}}]);
            onClose();
        })
    }

    const setDayAction = (e) => {
        setError(null);
        setErrorCode(null);

        if (e.target.value) {
            setDateLiteralValue(e.target.options[e.target.selectedIndex].text);
        }

        setDay(e.target.value)
    }

    const setTimeLiteral = (e) => {
        if (e.target.value) {
            setTimeLiteralValue(e.target.options[e.target.selectedIndex].text.replace(' - ',' ' + t('fields.and') + ' '));
        } else {
            setError(null);
            setErrorCode(null);
        }
        setTime(e.target.value);
    }

    const reScheduleCallback = () => {
        let postData = getPostData();
        postData['reschedule'] = true;
        scheduleCallback(postData);
    }

    const changeTimeZone = (e) => {
        setTimezone(e);
    }

    useEffect(() => {
        if (isLoaded === true) {
            setDay(null);
            setTime(null);
            setTimes([]);
            document.getElementById('cbscheduler-day').value = "";
            getDays();
        }
    },[timezone]);

    const scheduleCallback = (postData) => {

        setSubmitting(true);
        axios.post(props.base_path  + "cbscheduler/schedulecb", (typeof postData !== 'undefined' ? postData : getPostData())).then(result => {
            setErrors([]);
            setError(null);
            setErrorCode(null);

            if (result.data.error == true) {
                setSubmitting(false);
                if (result.data.messages) {
                    setErrors(result.data.messages);

                    // I was attempt error where information itself is validated
                    // even the format is correct everywhere
                    if (result.data.messages.errorModal) {
                        setAttempt(attempt + 1);
                    }
                }

                if (result.data.code) {
                    setErrorCode(result.data.code);
                }

                if (result.data.message) {
                    setError(result.data.message);
                }

            } else {
                setData(result.data.data);
                setScheduled(true);
            }
        });
    }

    useEffect(() => {
        if (day !== null) {
            setTimes([]);
            setTime(null);
            axios.get(props.base_path  + "cbscheduler/gettimes/"+day+"/(department)/" + department + "/(chat)/" + props.chat_id + '?tz=' + timezone).then(result => {
                setTimes(result.data);
                setTime(null);
            });
        }
    },[day]);

    useEffect(() => {
        getDays();
        getSubjects();
    },[]);

    const { t, i18n } = useTranslation('cbsheduler_chat');

    if (isLoaded === false) {
        return (<React.Fragment>
            ...
        </React.Fragment>)
    }

    var logoFormated = <div className="col-12">
        <div className="d-flex pb-1">
            {logo !== null && <div className="pe-2"><img src={logo} height="40"/></div>}
            <div className="ps-0 pt-1 flex-grow-1"><h5>{isCancelMode === true ? t('fields.cancel_title') : t('fields.schedule_title')}</h5></div>
            {props.mode == 'widget' && <div className="ps-2"><button type="button" onClick={(e) => onClose()} className="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button></div>}
        </div>
    </div>;

    if (errors.errorModal) {
        return (<React.Fragment>
            {logoFormated}
            <p className="text-danger">{errors.errorModal}</p>
            <div className="btn-group">
                {!errors.disableTryAgain && <button className="btn btn-sm btn-secondary" onClick={(e) => setErrors([])}>{t('fields.try_again')}</button>}
                {props.mode == 'widget' && <button className="btn btn-sm btn-secondary" onClick={(e) => goToAgent()}>{t('fields.live_support')}</button>}
                {props.mode != 'widget' && <button className="btn btn-sm btn-secondary" onClick={(e) => onClose()}>{t('fields.close')}</button>}
            </div>
        </React.Fragment>)
    }

    if (days.length == 0) {
        return (<React.Fragment>
            <div className="row">

                {logoFormated}

                <div className="col-12">
                    <div className="alert alert-light" role="alert">
                        {t('fields.no_free_days')}
                    </div>
                </div>

            </div>
        </React.Fragment>)
    }

    if (isCancelMode === true) {
        return <CancelModule username={username} phone={phone} email={email} base_path={props.base_path} timezone={timezone} dep_id={department} chat_id={props.chat_id} hash={props.hash} countries={countries !== null ? countries : undefined} logoFormated={logoFormated} setCancelMode={() => cancelScheduled(false)} defaultCountry={defaultCountry} />
    }



    return (
        <React.Fragment>
            <div className="row">

                {logoFormated}

                {isScheduled && <div className="col-12">{t('fields.call_scheduled')} <a href={cbData.ics}>{t('fields.download')}</a>.</div>}

                {!isScheduled && <div className="col-12">

                    <div className="row">
                        <div className="col-6 pe-2">
                            <div className="form-group">
                                <input title={t('fields.username')} placeholder={t('fields.username')} type="text" maxLength="250" onChange={(e) => setUsername(e.target.value)} className={"form-control form-control-sm"+(errors.username ? ' is-invalid' : '')} defaultValue={username} />
                                {errors.username && <div className="invalid-feedback">
                                    {errors.username}
                                </div>}
                            </div>
                        </div>
                        <div className="ps-2 col-6">
                            <div className="form-group">
                                <input title={t('fields.email')} placeholder={t('fields.email')} type="text" maxLength="250" defaultValue={email} onChange={(e) => setEmail(e.target.value)} className={"form-control form-control-sm"+(errors.email ? ' is-invalid' : '')} />
                                {errors.email && <div className="invalid-feedback">
                                    {errors.email}
                                </div>}
                            </div>
                        </div>
                    </div>

                    <div className="form-group">

                          <select title={t('fields.subject')} className={"form-control form-control-sm"+(errors.subject ? ' is-invalid' : '')} defaultValue={subject} onChange={(e) => setSubject(e.target.value)}>
                            <option value="">{t('fields.choose_subject')}</option>
                            {subjects.map(subject => (
                                <option value={subject.id}>{subject.name}</option>
                            ))}
                        </select>
                        {errors.subject && <div className="invalid-feedback">
                            {errors.subject}
                        </div>}
                    </div>

                    <div className="form-group">
                        <PhoneInput countries={countries !== null ? countries : undefined} international={true} className={"form-control form-control-sm"+(errors.phone ? ' is-invalid' : '')} defaultCountry={defaultCountry} placeholder={t('fields.enter_phone')} value={phone} onChange={setPhone}/>
                        {errors.phone && <div className="invalid-feedback">
                            {errors.phone}
                        </div>}
                        <small><i>{t('fields.include_country')}</i></small>
                    </div>

                    <div className="form-group mb-1">
                        <textarea placeholder={t('fields.problem')} maxLength="500" name="description" defaultValue={description} onChange={(e) => setDescription(e.target.value)} className={"form-control form-control-sm"+(errors.description ? ' is-invalid' : '')}></textarea>
                        {errors.description && <div className="invalid-feedback">
                            {errors.description}
                        </div>}
                    </div>

                    <p className="mb-2"><small>{t('fields.choose_day_time')}<button title={t('fields.choose_tz')} onClick={() => chooseTimeZone()} className="btn btn-sm btn-link pt-0 ps-1 pe-1 btn-no-outline text-decoration-none" type="button">{timezone} <span className="editable-icon">&#x0270E;</span></button>{t('fields.timezone')}</small></p>

                    {isChooseTZMode && <ChooseTZModule setTimeZone={(e) => changeTimeZone(e)} time_zone={timezone} base_path={props.base_path} />}

                    <div className="form-group">
                        <select id="cbscheduler-day" className={"form-control form-control-sm"+(errors.day ? ' is-invalid' : '')} defaultValue={day} onChange={(e) => setDayAction(e)}>
                            <option value="">{t('fields.choose_day')}</option>
                            {days.map(day => (
                                <option value={day.id}>{day.name}</option>
                            ))}
                        </select>
                        {errors.day && <div className="invalid-feedback">
                            {errors.day}
                        </div>}
                    </div>

                    {day && times.length > 0 && <div className="form-group">
                        <select className="form-control form-control-sm" defaultValue={time} className={"form-control form-control-sm"+(errors.time ? ' is-invalid' : '')} onChange={(e) => setTimeLiteral(e)}>
                            <option value="">{t('fields.choose_time')}</option>
                            {times.map(time => (
                                <option value={time.id}>{time.name}</option>
                            ))}
                        </select>
                        {errors.time && <div className="invalid-feedback">
                            {errors.time}
                        </div>}
                    </div>}

                    {day && times.length == 0 && <div className="form-group">
                        <i className="material-icons">&#xf113;</i> {t('fields.loading')}
                    </div>}

                    {error && <div className="alert alert-danger" role="alert">
                        {error}
                        {error_code && error_code == 100 && <div className="pt-3">
                            <div className="pb-1">{t('fields.reschedule_option')} {dateLiteralValue} {t('fields.between')} {timeLiteralValue}?</div>
                            <button type="button" disabled={isDisabled || isSubmitting} onClick={() => reScheduleCallback()} className="btn btn-sm btn-info">{isSubmitting && <i className="material-icons">&#xf113;</i>} {t('fields.yes')}</button>
                        </div>}
                    </div>}

                    {termsOfService && <div className={"form-check form-check-sm pb-2"}>
                        <input type="checkbox" id="id-terms-of-service" className={"form-check-input"+(errors.terms_of_service ? ' is-invalid' : '')} onChange={(e) => setTermsOfServiceAgree(e.target.checked)} />
                        <label className="form-check-label" for="id-terms-of-service"> <small>{termsOfService}</small></label>
                        {errors.terms_of_service && <div className="invalid-feedback fw-bold">
                            {errors.terms_of_service}
                        </div>}
                    </div>}

                    <div className="form-group mb-0">
                        <button type="button" disabled={isDisabled || isSubmitting} className="btn btn-sm btn-secondary" onClick={() => scheduleCallback()}>{isSubmitting && <i className="material-icons">&#xf113;</i>} {t('fields.schedule_callback')}</button>
                        <div>
                            <button type="button" onClick={() => cancelScheduled(true)} className="btn btn-sm text-secondary btn-link pull-right">{t('fields.cancel_scheduled')}</button>
                        </div>
                    </div>


                </div>}
            </div>
        </React.Fragment>
    );
}

export default CBScheduler