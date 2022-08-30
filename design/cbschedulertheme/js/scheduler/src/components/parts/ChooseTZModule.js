import React, { useEffect, useState, useReducer } from "react";
import axios from "axios";

import PhoneInput from 'react-phone-number-input'
import {useTranslation} from 'react-i18next';

const ChooseTZModule = props => {

    const { t, i18n } = useTranslation('cbsheduler_chat');
    const [isLoaded, setLoaded] = useState(false);
    const [timeZones, setTimeZones] = useState([]);

    /*const [phone, setPhone] = useState((props.phone != '' && props.phone != null) ? props.phone : null);
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
    }*/

    const getTimeZones = () => {
        axios.get(props.base_path  + "cbscheduler/gettz" ).then(result => {
            setTimeZones(result.data);
            setLoaded(true);
        });
    }

    useEffect(() => {
        getTimeZones();
    },[]);


    if (isLoaded === false) {
        return (<React.Fragment>
            ...
        </React.Fragment>)
    }

    return <div className="row">
        <div className="col-12 pb-2">
            <div className="form-group">
            <div className="input-group input-group-sm">
                <select className="form-control" onChange={(e) => {props.setTimeZone(e.target.value)}}>
                    {timeZones.map(timeZone => (
                        <option selected={props.time_zone == timeZone} value={timeZone}>{timeZone}</option>
                    ))}
                </select>
                <div className="input-group-append">
                    <span className="input-group-text">
                        <a onClick={(e) => {props.exitEditTZ()}} title={t('fields.finish_edit')}>&#10004;</a>
                    </span>
                </div>
            </div>
            </div>

        </div>
    </div>
}

export default React.memo(ChooseTZModule);