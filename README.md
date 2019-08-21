# Hebrew Calendar with ACF PRO
This simple Wordpress ACF calendar plugin is based on Roee Yossef excellent article at 
<a href="https://he.savvy.co.il/blog/%D7%95%D7%95%D7%A8%D7%93%D7%A4%D7%A8%D7%A1/display-events-on-hebrew-calendar-wordpress/" target="_blank">`https://he.savvy.co.il/blog/%D7%95%D7%95%D7%A8%D7%93%D7%A4%D7%A8%D7%A1/display-events-on-hebrew-calendar-wordpress/`</a>.

## How to use

- Download this repo and install it on your Wordpress site 

- You need to install ACF Pro in order to use it.

- You need to import the file acf-export-2019-08-20.json (in the plugin root) into ACF to create the fields needed for the calendar.

## Put this html in the page where you want the calendar to appear
```
<div class="custom-calendar-wrap">
    <div id="custom-inner" class="custom-inner">
        <div class="custom-header clearfix">
            <nav><span id="custom-prev" class="custom-prev"></span><span id="custom-next" class="custom-next"></span></nav>
            <h2 id="custom-month" class="custom-month"></h2>
            <h3 id="custom-year" class="custom-year"></h3></div>
        <div id="calendar" class="fc-calendar-container"></div>
    </div>
</div>
```