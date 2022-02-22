import React, { useEffect, useState, useReducer } from "react";
import axios from "axios";

import PhoneInput from 'react-phone-number-input'
import {useTranslation} from 'react-i18next';

const CancelModule = props => {

    const { t, i18n } = useTranslation('cbsheduler_chat');

    const [phone, setPhone] = useState((props.phone != '' && props.phone != null) ? props.phone : null);
    const [email, setEmail] = useState((props.email != '' && props.email != null) ? props.email : null);
    const [username, setUsername] = useState((props.username != '' && props.username != null && props.username != 'Visitor' && props.username != 'undefined') ? props.username : null);

    const [isSubmitting, setSubmitting] = useState(false);
    const [isDisabled, setDisabled] = useState(false);
    const [isScheduled, setScheduled] = useState(false);
    const [cbData, setData] = useState(null);

    // Error messages
    const [errors, setErrors] = useState([]);

    // Error message
    const [error, setError] = useState(null);
    const [error_code, setErrorCode] = useState(null);

    const cancelScheduled = () => {
        props.setCancelMode(false);
    }

    const getPostData = () => {
        return {
            'username':username,
            'timezone':props.timezone,
            'phone':phone,
            'email':email,
            'dep_id':props.dep_id,
            'chat_id':props.chat_id,
            'hash':props.hash
        };
    }

    const cancelCallbackAction = () => {
        setSubmitting(true);
        axios.post(props.base_path  + "cbscheduler/cancelschedulecb", (typeof postData !== 'undefined' ? postData : getPostData())).then(result => {
            setErrors([]);
            setError(null);
            setErrorCode(null);

            if (result.data.error == true) {
                setSubmitting(false);

                if (result.data.messages) {
                    setErrors(result.data.messages);
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

    return <div>

        <div className="row">
            {props.logoFormated}
        </div>

        {isScheduled && <div>

            <div className="alert alert-info" role="alert">
                {cbData.message}
            </div>

            <div className="form-group mb-0">
                <button type="button" onClick={() => cancelScheduled()} className="btn btn-sm text-secondary btn-link pull-right">&laquo; {t('fields.return')}</button>
            </div>
        </div>}

         {!isScheduled && <div>

             {error && <div className="alert alert-danger" role="alert">
                 {error}
             </div>}

            <div className="form-group">
                <PhoneInput countries={props.countries !== null ? props.countries : undefined} international={true} className={"form-control form-control-sm"+(errors.phone ? ' is-invalid' : '')} defaultCountry={props.defaultCountry} placeholder={t('fields.enter_phone')} value={phone} onChange={setPhone}/>
                {errors.phone && <div className="invalid-feedback">
                    {errors.phone}
                </div>}
                <small><i>{t('fields.include_country')}</i></small>
            </div>

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
                        <input title={t('fields.email')} placeholder={t('fields.email')} type="text" maxLength="250" defaultValue={email} onChange={(e) => setEmail(e.target.value)} className={"form-control form-control-sm"+(errors.email ? ' is-invalid' : '')} />
                        {errors.email && <div className="invalid-feedback">
                            {errors.email}
                        </div>}
                    </div>
                </div>
            </div>

            <div className="form-group mb-0">
                <button type="button" disabled={isDisabled || isSubmitting} className="btn btn-sm btn-secondary" onClick={() => cancelCallbackAction()}>{isSubmitting && <i className="material-icons">&#xf113;</i>} {t('fields.cancel_action')}</button>
                <div>
                    <button type="button" onClick={() => cancelScheduled()} className="btn btn-sm text-secondary btn-link pull-right">&laquo; {t('fields.return')}</button>
                </div>
            </div>

        </div>}

    </div>
}

export default React.memo(CancelModule);