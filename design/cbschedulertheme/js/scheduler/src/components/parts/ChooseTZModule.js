import React, { useEffect, useState, useReducer } from "react";
import axios from "axios";

import PhoneInput from 'react-phone-number-input'
import {useTranslation} from 'react-i18next';

const ChooseTZModule = props => {

    const { t, i18n } = useTranslation('cbsheduler_chat');
    const [isLoaded, setLoaded] = useState(false);
    const [timeZones, setTimeZones] = useState([]);

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