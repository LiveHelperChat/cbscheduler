import React, { useEffect, useState, useReducer } from "react";
import axios from "axios";

import PhoneInput from 'react-phone-number-input'
import {useTranslation} from 'react-i18next';

const CBScheduler = props => {

    // Attributes lists
    const [days, setDays] = useState([]);
    const [times, setTimes] = useState([]);
    const [subjects, setSubjects] = useState([]);

    // Error messages
    const [errors, setErrors] = useState([]);

    // Error message
    const [error, setError] = useState(null);

    // Single type attribtues
    const [day, setDay] = useState(null);
    const [time, setTime] = useState(null);
    const [username, setUsername] = useState((props.username != '' && props.username != null && props.username != 'Visitor' && props.username != 'undefined') ? props.username : null);
    const [subject, setSubject] = useState(null);
    const [description, setDescription] = useState(null);
    const [phone, setPhone] = useState(null);
    const [email, setEmail] = useState(null);
    const [department, setDepartment] = useState(props.dep_id);

    // logical attributes
    const [isDisabled, setDisabled] = useState(false);
    const [isScheduled, setScheduled] = useState(false);
    const [cbData, setData] = useState(null);
    const [defaultCountry, setDefaultCountry] = useState(null);
    const [logo, setLogo] = useState(null);
    const [isLoaded, setLoaded] = useState(false);

    const onClose = () => {
        props.ee.emitEvent('endCheduler',[])
    }

    // Helpers
    const getTzOffset = () => {
        try {
            return Intl.DateTimeFormat().resolvedOptions().timeZone;
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
        axios.get(props.base_path  + "cbscheduler/getdays/(department)/" + department + "/(chat)/" + props.chat_id + '/(vid)/'+ props.vid + '/(theme)/'+ props.theme + '?tz=' + timezone ).then(result => {
            setDays(result.data.days);
            setDefaultCountry(result.data.default_country);
            setLogo(result.data.logo);
            if (result.data.username && username === null) {
                setUsername(result.data.username);
            }

            if (department === null) {
                setDepartment(result.data.department);
            }

            setLoaded(true);
        });
    }

    const getSubjects = (e) => {
        axios.get(props.base_path  + "cbscheduler/getsubjects").then(result => {
            setSubjects(result.data);
        });
    }

    const scheduleCallback = () => {
        let scheduleData = {
            'username':username,
            'timezone':timezone,
            'dep_id':department,
            'chat_id':props.chat_id,
            'subject':subject,
            'description':description,
            'phone':phone,
            'email':email,
            'day':day,
            'time':time
        };

        axios.post(props.base_path  + "cbscheduler/schedulecb", scheduleData).then(result => {
            setErrors([]);
            setError(null);

            if (result.data.error == true) {
                if (result.data.messages) {
                    setErrors(result.data.messages);
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
            axios.get(props.base_path  + "cbscheduler/gettimes/"+day+"/(department)/" + department + "/(chat)/" + props.chat_id + '?tz=' + timezone).then(result => {
                setTimes(result.data);
                setTime(null);
            });
        }
    },[day]);

    useEffect(() => {
        if (!username || !timezone || !subject || !description || !phone || !email || !day || !time) {
            setDisabled(true);
        } else {
            setDisabled(false);
        }
    });

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

    if (days.length == 0) {
        return (<React.Fragment>
            <div className="row">

                <div className="col-12">
                    <div className="d-flex pb-1">
                        {logo !== null && <div><img src={logo} height="40"/></div>}
                        <div className="pl-2 pt-1 flex-grow-1"><h5>{t('fields.schedule_title')}</h5></div>
                        {props.mode == 'widget' && <div className="pl-2"><button type="button" onClick={(e) => onClose()} className="close float-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>}
                    </div>
                </div>

                <div className="col-12">
                    <div className="alert alert-light" role="alert">
                        {t('fields.no_free_days')}
                    </div>
                </div>

            </div>
        </React.Fragment>)
    }

    return (
        <React.Fragment>
            <div className="row">

                <div className="col-12">
                    <div className="d-flex pb-1">
                        {logo !== null && <div><img src={logo} height="40"/></div>}
                        <div className="pl-2 pt-1 flex-grow-1"><h5>{t('fields.schedule_title')}</h5></div>
                        {props.mode == 'widget' && <div className="pl-2"><button type="button" onClick={(e) => onClose()} className="close float-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>}
                    </div>
                </div>

                {isScheduled && <div className="col-12">{t('fields.call_scheduled')} <a href={cbData.ics}>{t('fields.download')}</a>.</div>}

                {!isScheduled && <div className="col-12">

                    <div className="row">
                        <div className="col-6 pr-2">
                            <div className="form-group">
                                <input title={t('fields.username')} placeholder={t('fields.username')} type="text" maxLength="250" onChange={(e) => setUsername(e.target.value)} className={"form-control form-control-sm"+(errors.username ? ' is-invalid' : '')} defaultValue={username} />
                                {errors.username && <div className="invalid-feedback">
                                    {errors.username}
                                </div>}
                            </div>
                        </div>
                        <div className="pl-2 col-6">
                            <div className="form-group">
                                <input title={t('fields.email')} placeholder={t('fields.email')} type="text" maxLength="250" onChange={(e) => setEmail(e.target.value)} className={"form-control form-control-sm"+(errors.email ? ' is-invalid' : '')} />
                                {errors.email && <div className="invalid-feedback">
                                    {errors.email}
                                </div>}
                            </div>
                        </div>
                    </div>

                    <div className="form-group">
                          <select title={t('fields.subject')} className={"form-control form-control-sm"+(errors.subject ? ' is-invalid' : '')} onChange={(e) => setSubject(e.target.value)}>
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
                        <PhoneInput international={true} className={"form-control form-control-sm"+(errors.phone ? ' is-invalid' : '')} defaultCountry={defaultCountry} placeholder={t('fields.enter_phone')} value="" onChange={setPhone}/>
                        {errors.phone && <div className="invalid-feedback">
                            {errors.phone}
                        </div>}
                        <small><i>{t('fields.include_country')}</i></small>
                    </div>

                    <div className="form-group mb-1">
                        <textarea placeholder={t('fields.problem')} maxLength="500" name="description" onChange={(e) => setDescription(e.target.value)} className={"form-control form-control-sm"+(errors.description ? ' is-invalid' : '')}></textarea>
                        {errors.description && <div className="invalid-feedback">
                            {errors.description}
                        </div>}
                    </div>

                    <p className="mb-2"><small>{t('fields.choose_day_time', {timezone:timezone})}</small></p>

                    <div className="form-group">
                        <select className={"form-control form-control-sm"+(errors.day ? ' is-invalid' : '')} onChange={(e) => setDay(e.target.value)}>
                            <option value="">{t('fields.choose_day')}</option>
                            {days.map(day => (
                                <option value={day.id}>{day.name}</option>
                            ))}
                        </select>
                        {errors.day && <div className="invalid-feedback">
                            {errors.day}
                        </div>}
                    </div>

                    {day && <div className="form-group">
                        <select className="form-control form-control-sm" className={"form-control form-control-sm"+(errors.time ? ' is-invalid' : '')} onChange={(e) => setTime(e.target.value)}>
                            <option value="">{t('fields.choose_time')}</option>
                            {times.map(time => (
                                <option value={time.id}>{time.name}</option>
                            ))}
                        </select>
                        {errors.time && <div className="invalid-feedback">
                            {errors.time}
                        </div>}
                    </div>}

                    {error && <div className="alert alert-danger" role="alert">
                        {error}
                    </div>}

                    <div className="form-group mb-0">
                        <input type="button" disabled={isDisabled} className="btn btn-sm btn-secondary" onClick={() => scheduleCallback()} value={t('fields.schedule_callback')} />
                    </div>


                </div>}
            </div>
        </React.Fragment>
    );
}

export default CBScheduler