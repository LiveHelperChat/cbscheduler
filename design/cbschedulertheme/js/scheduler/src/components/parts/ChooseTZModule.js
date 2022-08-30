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
                <select className="form-control form-control-sm" onChange={(e) => {props.setTimeZone(e.target.value)}}>
                    {timeZones.map(timeZone => (
                        <option selected={props.time_zone == timeZone} value={timeZone}>{timeZone}</option>
                    ))}
                </select>
            </div>
        </div>
    </div>
}

export default React.memo(ChooseTZModule);