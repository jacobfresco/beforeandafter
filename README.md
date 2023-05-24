## Info

* Name: Before And After
* Current version: 0.3.2
* Status: Stable / On Hold

## Versions

* 0.3.2 – Multiple bugfixes for 0.3.0
* 0.3.0 - ON changed to SINGLE
* 0.3.0 - Partly rewritten code for flexibility
* 0.2.3 - Multiple bugfixes
* 0.2.0 - Change to use the timezone set in Wordpress
* 0.2.0 - Accepts not only dates but also and end time or from-time
* 0.2.0 - Added the ON-tag to show on a specific date
* 0.1.0 – First commit

## Installation

Upload the file before-dafter.php to the plugin directory of your Wordpress installation and activate the plugin. Use the codes below to use the plugin in an article/blogpost:

## Usage
### Before
To show a text until a certain date and time, please use the syntax below
```
<before YYYY-MM-DD HH:MM>Text</before>
```
Please note that BEFORE-tags without a time will show the text until the set date (i.e the day before until 23:59:59)

### After
To show a text after a certain date and time, please use the syntaxt below
```
<after YYYY-MM-DD HH:MM>Text</after>
```

### Single
To show a text on a specific date only, please use the syntax below
```
<SINGLE YYYY-MM-DD>Text</SINGLE>
```
Please note that SINGLE doens't have a time; setting a time for this tag will result in a garbled, and probably incorrect display. 

### Nested tags
Nested tags are supported, as long as the tags aren't nested within itself. Please see below for examples
```
<before YYYY-MM-DD HH:MM>This will work
  <single YYYY-MM-DD>, even today</single>.
</before>
```
```
<before YYYY-MM-DD HH:MM>This one won't work
  <before YYYY-MM-DD HH:MM>, not even tomorrow</before>
</before>
```
