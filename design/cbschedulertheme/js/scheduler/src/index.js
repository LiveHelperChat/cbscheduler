import React from 'react';
import ReactDOM from 'react-dom';
import { Suspense, lazy } from 'react';
import i18n from "./components/i18n/i18n";

const CBScheduler = React.lazy(() => import('./components/CBScheduler'));

let eeScheduler = null;

if (typeof ee !== 'undefined') {
    eeScheduler = ee;
} else {
    eeScheduler = window.lhcHelperfunctions.eventEmitter;
}

eeScheduler.addListener('endCheduler', function(props) {
    var el = document.getElementById('CBScheduler');
    ReactDOM.unmountComponentAtNode(el);
    var elem = document.getElementById('cbscheduler-modal');
    elem.parentNode.removeChild(elem);
    
    eeScheduler.emitEvent('cbscheduler.close_modal',[props]);
});

eeScheduler.addListener('loadCheduler',(params) => {
    __webpack_public_path__ = params['path'];
    var el = document.getElementById('CBScheduler');
    if (el !== null) {
        ReactDOM.render(
            <Suspense fallback="..."><CBScheduler widget={params.widget} parent_id={params.parent_id || null} description={params.description || null} phone={params.phone || null} subject={params.subject || null} email={params.email || null} hash={params.hash} mode={params.mode} ee={eeScheduler} username={params.username} vid={params.vid} theme={params.theme} base_path={typeof WWW_DIR_JAVASCRIPT !== 'undefined' ? WWW_DIR_JAVASCRIPT : window.lhcChat['base_url']} dep_id={params.dep_id} chat_id={params.chat_id} /></Suspense>,
            el
        );
    }
})
