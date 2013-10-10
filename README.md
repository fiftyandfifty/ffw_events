## Fifty & Fifty Frame Work Events Plugin
==========

Add events to your site.


### Features

Quickly change the slug with

```php
if( !defined('FFW_EVENTS_SLUG') ){
	define( 'FFW_EVENTS_SLUG', 'schedule' );
}
```

or quickly change the labels with

```php
function ffw_events_labels( $labels ) {
	$labels = array(
	   'singular' => __('Schedule', 'your-domain'),
	   'plural' => __('Schedules', 'your-domain')
	);
	return $labels;
}
add_filter('ffw_events_default_name', 'ffw_events_labels');
```


### Changelog

Coming soon.