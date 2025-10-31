# Bethink Safety Net

A safety net plugin designed to be "set and forget" for production sites.

Activate this plugin, and it should ideally do ... nothing.  Until someone clones the site to a development or staging site -- at which point it should detect the change, and prompt you to disable plugins, purge options, and other items to ensure cron jobs don't email customers, mail doesn't get sent out, etc.
