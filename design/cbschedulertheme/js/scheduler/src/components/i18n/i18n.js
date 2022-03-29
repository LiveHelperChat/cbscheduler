import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';
import Backend from 'i18next-xhr-backend';

var date = new Date();

i18n.use(Backend).use(initReactI18next).init({
    backend: {
        loadPath: (typeof WWW_DIR_JAVASCRIPT !== 'undefined' ? WWW_DIR_JAVASCRIPT : window.lhcChat['base_url'])+'cbscheduler/lang/{{ns}}?l={{lng}}&v=4'+(""+date.getFullYear() + date.getMonth() + date.getDate())
    },
    lng: 'eng',
    fallbackLng: 'eng',
    defaultNS: 'cbsheduler_chat',
    ns: 'cbsheduler_chat',
    debug: false,
    interpolation: {
        escapeValue: false, // not needed for react as it escapes by default
    }
});

export default i18n;