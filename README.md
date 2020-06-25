
## What's the purpose of this extension?

This extension adds options to schedule a callback from chat widget.

![See image](/design/frontendnew/images/stats.png)

## Integration with a bot

You can trigger modal window also from a bot.

![See image](/design/frontendnew/images/stats.png)

## Install

Execute SQL file `doc/install.sql` or

`php cron.php -s site_admin -e cbscheduler -c cron/update_structure`

Install composer dependencies

`composer.phar update`

## Commands in the chat
`!schedule`

New widget javascript

```js
// New widget
function scheduleCallbackNewWidget(){
    window.$_LHC.eventListener.emitEvent('sendChildExtEvent',[{'cmd':'cbscheduler','arg':{}}]);
    // Delay for 5 seconds
    // window.$_LHC.eventListener.emitEvent('sendChildExtEvent',[{'cmd':'cbscheduler','arg':{"delay":5}}]);
    window.$_LHC.eventListener.emitEvent('showWidget');
}
```

Old widget javascript

```js
// Old widget
function scheduleCallbackNewWidget(){
    lh_inst.executeExtension('cbscheduler',{"delay":0});
    // Delay for 5 seconds
    // lh_inst.executeExtension('cbscheduler',{"delay":5});
}
```