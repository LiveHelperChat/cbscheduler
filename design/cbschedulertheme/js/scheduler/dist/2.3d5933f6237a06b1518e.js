(window.webpackJsonpLHCReactAPPCBScheduler=window.webpackJsonpLHCReactAPPCBScheduler||[]).push([[2],{63:function(e,t,a){"use strict";a.r(t);var n=a(2),l=a.n(n),c=a(19),s=a.n(c),r=a(0),i=a.n(r),o=a(21),m=a.n(o),u=a(23),d=a(64),f=i.a.memo((function(e){var t=Object(d.a)("cbsheduler_chat"),a=t.t,n=(t.i18n,Object(r.useState)(""!=e.phone&&null!=e.phone?e.phone:null)),l=s()(n,2),c=l[0],o=l[1],f=Object(r.useState)(""!=e.email&&null!=e.email?e.email:null),b=s()(f,2),h=b[0],p=b[1],v=Object(r.useState)(""!=e.username&&null!=e.username&&"Visitor"!=e.username&&"undefined"!=e.username?e.username:null),E=s()(v,2),g=E[0],N=E[1],_=Object(r.useState)(!1),j=s()(_,2),O=j[0],y=j[1],S=Object(r.useState)(!1),C=s()(S,2),k=C[0],x=(C[1],Object(r.useState)(!1)),w=s()(x,2),z=w[0],F=w[1],T=Object(r.useState)(null),V=s()(T,2),D=V[0],L=V[1],M=Object(r.useState)([]),B=s()(M,2),I=B[0],P=B[1],A=Object(r.useState)(null),Z=s()(A,2),H=Z[0],J=Z[1],R=Object(r.useState)(null),Y=s()(R,2),Q=(Y[0],Y[1]),U=function(){e.setCancelMode(!1)},q=function(){y(!0),m.a.post(e.base_path+"cbscheduler/cancelschedulecb","undefined"!=typeof postData?postData:{username:g,timezone:e.timezone,phone:c,email:h,dep_id:e.dep_id,chat_id:e.chat_id,hash:e.hash}).then((function(e){P([]),J(null),Q(null),1==e.data.error?(y(!1),e.data.messages&&P(e.data.messages),e.data.code&&Q(e.data.code),e.data.message&&J(e.data.message)):(L(e.data.data),F(!0))}))};return i.a.createElement("div",null,i.a.createElement("div",{className:"row"},e.logoFormated),z&&i.a.createElement("div",null,i.a.createElement("div",{className:"alert alert-info",role:"alert"},a("fields.cancel_success",D.cancel_data)),i.a.createElement("div",{className:"form-group mb-0"},i.a.createElement("button",{type:"button",onClick:function(){return U()},className:"btn btn-sm text-secondary btn-link pull-right"},"« ",a("fields.return")))),!z&&i.a.createElement("div",null,H&&i.a.createElement("div",{className:"alert alert-danger",role:"alert"},H),i.a.createElement("div",{className:"form-group"},i.a.createElement(u.a,{countries:null!==e.countries?e.countries:void 0,international:!0,className:"form-control form-control-sm"+(I.phone?" is-invalid":""),defaultCountry:e.defaultCountry,placeholder:a("fields.enter_phone"),value:c,onChange:o}),I.phone&&i.a.createElement("div",{className:"invalid-feedback"},I.phone),i.a.createElement("small",null,i.a.createElement("i",null,a("fields.include_country")))),i.a.createElement("div",{className:"row"},i.a.createElement("div",{className:"col-6 pe-2"},i.a.createElement("div",{className:"form-group"},i.a.createElement("input",{title:a("fields.username"),placeholder:a("fields.username"),type:"text",maxLength:"250",onChange:function(e){return N(e.target.value)},className:"form-control form-control-sm"+(I.username?" is-invalid":""),defaultValue:g}),I.username&&i.a.createElement("div",{className:"invalid-feedback"},I.username))),i.a.createElement("div",{className:"ps-2 col-6"},i.a.createElement("div",{className:"form-group"},i.a.createElement("input",{title:a("fields.email"),placeholder:a("fields.email"),type:"text",maxLength:"250",defaultValue:h,onChange:function(e){return p(e.target.value)},className:"form-control form-control-sm"+(I.email?" is-invalid":"")}),I.email&&i.a.createElement("div",{className:"invalid-feedback"},I.email)))),i.a.createElement("div",{className:"form-group mb-0"},i.a.createElement("button",{type:"button",disabled:k||O,className:"btn btn-sm btn-secondary",onClick:function(){return q()}},O&&i.a.createElement("i",{className:"material-icons"},"")," ",a("fields.cancel_action")),i.a.createElement("div",null,i.a.createElement("button",{type:"button",onClick:function(){return U()},className:"btn btn-sm text-secondary btn-link pull-right"},"« ",a("fields.return"))))))})),b=i.a.memo((function(e){var t=Object(d.a)("cbsheduler_chat"),a=(t.t,t.i18n,Object(r.useState)(!1)),n=s()(a,2),l=n[0],c=n[1],o=Object(r.useState)([]),u=s()(o,2),f=u[0],b=u[1];return Object(r.useEffect)((function(){m.a.get(e.base_path+"cbscheduler/gettz").then((function(e){b(e.data),c(!0)}))}),[]),!1===l?i.a.createElement(i.a.Fragment,null,"..."):i.a.createElement("div",{className:"row"},i.a.createElement("div",{className:"col-12 pb-2"},i.a.createElement("div",{className:"form-group"},i.a.createElement("select",{className:"form-control form-control-sm",onChange:function(t){e.setTimeZone(t.target.value)}},f.map((function(t){return i.a.createElement("option",{selected:e.time_zone==t,value:t},t)}))))))}));t.default=function(e){var t,a=Object(r.useState)([]),n=s()(a,2),c=n[0],o=n[1],h=Object(r.useState)([]),p=s()(h,2),v=p[0],E=p[1],g=Object(r.useState)([]),N=s()(g,2),_=N[0],j=N[1],O=Object(r.useState)([]),y=s()(O,2),S=y[0],C=y[1],k=Object(r.useState)(null),x=s()(k,2),w=x[0],z=x[1],F=Object(r.useState)(null),T=s()(F,2),V=T[0],D=T[1],L=Object(r.useState)(null),M=s()(L,2),B=M[0],I=M[1],P=Object(r.useState)(null),A=s()(P,2),Z=A[0],H=A[1],J=Object(r.useState)(null),R=s()(J,2),Y=R[0],Q=R[1],U=Object(r.useState)(null),q=s()(U,2),G=q[0],K=q[1],W=Object(r.useState)(""!=e.username&&null!=e.username&&"Visitor"!=e.username&&"undefined"!=e.username?e.username:null),X=s()(W,2),$=X[0],ee=X[1],te=Object(r.useState)(""!=e.subject&&null!=e.subject?e.subject:null),ae=s()(te,2),ne=ae[0],le=ae[1],ce=Object(r.useState)(""!=e.description&&null!=e.description?e.description:null),se=s()(ce,2),re=se[0],ie=se[1],oe=Object(r.useState)(""!=e.phone&&null!=e.phone?e.phone:null),me=s()(oe,2),ue=me[0],de=me[1],fe=Object(r.useState)(""!=e.email&&null!=e.email?e.email:null),be=s()(fe,2),he=be[0],pe=be[1],ve=Object(r.useState)(null),Ee=s()(ve,2),ge=Ee[0],Ne=Ee[1],_e=Object(r.useState)(e.dep_id),je=s()(_e,2),Oe=je[0],ye=je[1],Se=Object(r.useState)(null),Ce=s()(Se,2),ke=Ce[0],xe=Ce[1],we=Object(r.useState)(!1),ze=s()(we,2),Fe=ze[0],Te=ze[1],Ve=Object(r.useState)(!1),De=s()(Ve,2),Le=De[0],Me=De[1],Be=Object(r.useState)(!1),Ie=s()(Be,2),Pe=Ie[0],Ae=(Ie[1],Object(r.useState)(!1)),Ze=s()(Ae,2),He=Ze[0],Je=Ze[1],Re=Object(r.useState)(!1),Ye=s()(Re,2),Qe=Ye[0],Ue=Ye[1],qe=Object(r.useState)(null),Ge=s()(qe,2),Ke=Ge[0],We=Ge[1],Xe=Object(r.useState)(null),$e=s()(Xe,2),et=$e[0],tt=$e[1],at=Object(r.useState)(null),nt=s()(at,2),lt=nt[0],ct=nt[1],st=Object(r.useState)(null),rt=s()(st,2),it=rt[0],ot=rt[1],mt=Object(r.useState)(!1),ut=s()(mt,2),dt=ut[0],ft=ut[1],bt=Object(r.useState)(!1),ht=s()(bt,2),pt=ht[0],vt=ht[1],Et=Object(r.useState)(0),gt=s()(Et,2),Nt=gt[0],_t=gt[1],jt=function(){e.ee.emitEvent("endCheduler",[e])},Ot=Object(r.useState)(function(){try{var e=Intl.DateTimeFormat().resolvedOptions().timeZone;return"undefined"==e&&(e="UTC"),e}catch(e){Date.prototype.stdTimezoneOffset=function(){var e=new Date(this.getFullYear(),0,1),t=new Date(this.getFullYear(),6,1);return Math.max(e.getTimezoneOffset(),t.getTimezoneOffset())},Date.prototype.dst=function(){return this.getTimezoneOffset()<this.stdTimezoneOffset()};var t=new Date;return(t.dst()?t.getTimezoneOffset():t.getTimezoneOffset()-60)/60*-1}}()),yt=s()(Ot,2),St=yt[0],Ct=yt[1],kt=function(){m.a.get(e.base_path+"cbscheduler/getdays/(department)/"+Oe+"/(chat)/"+e.chat_id+"/(hash)/"+e.hash+"/(vid)/"+e.vid+"/(theme)/"+e.theme+"?tz="+St).then((function(t){o(t.data.days),tt(t.data.default_country),ct(t.data.logo),t.data.username&&(null===$||e.chat_id)&&ee(t.data.username),t.data.email&&pe(t.data.email),t.data.countries&&Ne(t.data.countries),t.data.terms_of_service&&xe(t.data.terms_of_service),t.data.maintenance_mode&&ot(t.data.maintenance_mode),null===Oe&&ye(t.data.department),ft(!0)}))},xt=function(e){Te(e)},wt=function(){return{username:$,timezone:St,dep_id:Oe,chat_id:e.chat_id,parent_id:e.parent_id,hash:e.hash,subject:ne,description:re,phone:ue,email:he,day:B,time:Z,attempt:Nt,terms_agree:pt}};Object(r.useEffect)((function(){!0===dt&&(I(null),H(null),E([]),document.getElementById("cbscheduler-day").value="",kt())}),[St]);var zt=function(t){Je(!0),m.a.post(e.base_path+"cbscheduler/schedulecb",void 0!==t?t:wt()).then((function(t){C([]),z(null),D(null),1==t.data.error?(e.ee.emitEvent("cbscheduler.event_tracker",[{ea:"CBValidationFailed"}]),Je(!1),t.data.messages&&(C(t.data.messages),t.data.messages.errorModal&&_t(Nt+1)),t.data.code&&D(t.data.code),t.data.message&&z(t.data.message)):(We(t.data.data),Ue(!0),e.ee.emitEvent("cbscheduler.event_tracker",[{ea:"CBSCheduled"}]))}))};Object(r.useEffect)((function(){null!==B&&(E([]),H(null),m.a.get(e.base_path+"cbscheduler/gettimes/"+B+"/(department)/"+Oe+"/(chat)/"+e.chat_id+"?tz="+St).then((function(e){E(e.data),H(null)})))}),[B]),Object(r.useEffect)((function(){kt(),m.a.get(e.base_path+"cbscheduler/getsubjects/(department)/"+Oe).then((function(e){j(e.data)}))}),[]);var Ft=Object(d.a)("cbsheduler_chat"),Tt=Ft.t;Ft.i18n;if(!1===dt)return i.a.createElement(i.a.Fragment,null,"...");var Vt=i.a.createElement("div",{className:"col-12"},i.a.createElement("div",{className:"d-flex pb-1"},null!==lt&&i.a.createElement("div",{className:"pe-2"},i.a.createElement("img",{src:lt,height:"40"})),i.a.createElement("div",{className:"ps-0 pt-1 flex-grow-1"},i.a.createElement("h5",null,Tt(!0===Fe?"fields.cancel_title":"fields.schedule_title"))),"widget"==e.mode&&i.a.createElement("div",{className:"ps-2"},i.a.createElement("button",{type:"button",onClick:function(e){return jt()},className:"btn-close float-end","data-bs-dismiss":"modal","aria-label":"Close"}))));return it||S.maintenance_mode?i.a.createElement(i.a.Fragment,null,Vt,i.a.createElement("div",{className:"alert alert-info",role:"alert"},it||S.maintenance_mode)):S.errorModal?i.a.createElement(i.a.Fragment,null,Vt,i.a.createElement("p",{className:"text-danger"},S.errorModal),i.a.createElement("div",{className:"btn-group"},!S.disableTryAgain&&i.a.createElement("button",{className:"btn btn-sm btn-secondary",onClick:function(e){return C([])}},Tt("fields.try_again")),"widget"==e.mode&&i.a.createElement("button",{className:"btn btn-sm btn-secondary",onClick:function(t){m.a.post(e.base_path+"cbscheduler/gotoagent",wt()).then((function(t){e.ee.emitEvent("cbscheduler.live_support",[{chat_id:e.chat_id,fields:{Question:Tt("fields.verification_failed")}}]),jt()}))}},Tt("fields.live_support")),"widget"!=e.mode&&i.a.createElement("button",{className:"btn btn-sm btn-secondary",onClick:function(e){return jt()}},Tt("fields.close")))):0==c.length?i.a.createElement(i.a.Fragment,null,i.a.createElement("div",{className:"row"},Vt,i.a.createElement("div",{className:"col-12"},i.a.createElement("div",{className:"alert alert-light",role:"alert"},Tt("fields.no_free_days"))))):!0===Fe?i.a.createElement(f,{username:$,phone:ue,email:he,base_path:e.base_path,timezone:St,dep_id:Oe,chat_id:e.chat_id,hash:e.hash,countries:null!==ge?ge:void 0,logoFormated:Vt,setCancelMode:function(){return xt(!1)},defaultCountry:et}):i.a.createElement(i.a.Fragment,null,i.a.createElement("div",{className:"row"},Vt,Qe&&i.a.createElement("div",{className:"col-12"},Tt("fields.call_scheduled")," ",i.a.createElement("a",{href:Ke.ics},Tt("fields.download")),"."),!Qe&&i.a.createElement("div",{className:"col-12"},i.a.createElement("div",{className:"row"},i.a.createElement("div",{className:"col-6 pe-2"},i.a.createElement("div",{className:"form-group"},i.a.createElement("input",{title:Tt("fields.username"),placeholder:Tt("fields.username"),type:"text",maxLength:"50",onChange:function(e){return ee(e.target.value)},className:"form-control form-control-sm"+(S.username?" is-invalid":""),defaultValue:$}),S.username&&i.a.createElement("div",{className:"invalid-feedback"},S.username))),i.a.createElement("div",{className:"ps-2 col-6"},i.a.createElement("div",{className:"form-group"},i.a.createElement("input",{title:Tt("fields.email"),placeholder:Tt("fields.email"),type:"text",maxLength:"50",defaultValue:he,onChange:function(e){return pe(e.target.value)},className:"form-control form-control-sm"+(S.email?" is-invalid":"")}),S.email&&i.a.createElement("div",{className:"invalid-feedback"},S.email)))),i.a.createElement("div",{className:"form-group"},i.a.createElement("select",{title:Tt("fields.subject"),className:"form-control form-control-sm"+(S.subject?" is-invalid":""),defaultValue:ne,onChange:function(e){return le(e.target.value)}},i.a.createElement("option",{value:""},Tt("fields.choose_subject")),_.map((function(e){return i.a.createElement("option",{value:e.id},e.name)}))),S.subject&&i.a.createElement("div",{className:"invalid-feedback"},S.subject)),i.a.createElement("div",{className:"form-group"},i.a.createElement(u.a,{countries:null!==ge?ge:void 0,international:!0,className:"form-control form-control-sm"+(S.phone?" is-invalid":""),defaultCountry:et,placeholder:Tt("fields.enter_phone"),value:ue,onChange:de}),S.phone&&i.a.createElement("div",{className:"invalid-feedback"},S.phone),i.a.createElement("small",null,i.a.createElement("i",null,Tt("fields.include_country")))),i.a.createElement("div",{className:"form-group mb-1"},i.a.createElement("textarea",{placeholder:Tt("fields.problem"),maxLength:"500",name:"description",defaultValue:re,onChange:function(e){return ie(e.target.value)},className:"form-control form-control-sm"+(S.description?" is-invalid":"")}),S.description&&i.a.createElement("div",{className:"invalid-feedback"},S.description)),i.a.createElement("p",{className:"mb-2"},i.a.createElement("small",null,Tt("fields.choose_day_time"),i.a.createElement("button",{title:Tt("fields.choose_tz"),onClick:function(){Me(!Le)},className:"btn btn-sm btn-link pt-0 ps-1 pe-1 btn-no-outline text-decoration-none",type:"button"},St," ",i.a.createElement("span",{className:"editable-icon"},"✎")),Tt("fields.timezone"))),Le&&i.a.createElement(b,{setTimeZone:function(e){return function(e){Ct(e)}(e)},time_zone:St,base_path:e.base_path}),i.a.createElement("div",{className:"form-group"},i.a.createElement("select",{id:"cbscheduler-day",className:"form-control form-control-sm"+(S.day?" is-invalid":""),defaultValue:B,onChange:function(e){return function(e){z(null),D(null),e.target.value&&K(e.target.options[e.target.selectedIndex].text),I(e.target.value)}(e)}},i.a.createElement("option",{value:""},Tt("fields.choose_day")),c.map((function(e){return i.a.createElement("option",{value:e.id},e.name)}))),S.day&&i.a.createElement("div",{className:"invalid-feedback"},S.day)),B&&v.length>0&&i.a.createElement("div",{className:"form-group"},i.a.createElement("select",(t={className:"form-control form-control-sm",defaultValue:Z},l()(t,"className","form-control form-control-sm"+(S.time?" is-invalid":"")),l()(t,"onChange",(function(e){return function(e){e.target.value?Q(e.target.options[e.target.selectedIndex].text.replace(" - "," "+Tt("fields.and")+" ")):(z(null),D(null)),H(e.target.value)}(e)})),t),i.a.createElement("option",{value:""},Tt("fields.choose_time")),v.map((function(e){return i.a.createElement("option",{value:e.id},e.name)}))),S.time&&i.a.createElement("div",{className:"invalid-feedback"},S.time)),B&&0==v.length&&i.a.createElement("div",{className:"form-group"},i.a.createElement("i",{className:"material-icons"},"")," ",Tt("fields.loading")),w&&i.a.createElement("div",{className:"alert alert-danger",role:"alert"},w,V&&100==V&&i.a.createElement("div",{className:"pt-3"},i.a.createElement("div",{className:"pb-1"},Tt("fields.reschedule_option")," ",G," ",Tt("fields.between")," ",Y,"?"),i.a.createElement("button",{type:"button",disabled:Pe||He,onClick:function(){return function(){var e=wt();e.reschedule=!0,zt(e)}()},className:"btn btn-sm btn-info"},He&&i.a.createElement("i",{className:"material-icons"},"")," ",Tt("fields.yes")))),ke&&i.a.createElement("div",{className:"form-check form-check-sm pb-2"},i.a.createElement("input",{type:"checkbox",id:"id-terms-of-service",className:"form-check-input"+(S.terms_of_service?" is-invalid":""),onChange:function(e){return vt(e.target.checked)}}),i.a.createElement("label",{className:"form-check-label",for:"id-terms-of-service"}," ",i.a.createElement("small",null,ke)),S.terms_of_service&&i.a.createElement("div",{className:"invalid-feedback fw-bold"},S.terms_of_service)),i.a.createElement("div",{className:"form-group mb-0"},i.a.createElement("button",{type:"button",disabled:Pe||He,className:"btn btn-sm btn-secondary",onClick:function(){return zt()}},He&&i.a.createElement("i",{className:"material-icons"},"")," ",Tt("fields.schedule_callback")),i.a.createElement("div",null,i.a.createElement("button",{type:"button",onClick:function(){return xt(!0)},className:"btn btn-sm text-secondary btn-link pull-right"},Tt("fields.cancel_scheduled")))))))}}}]);