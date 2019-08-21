# Hebrew Calendar with ACF PRO
This simple Wordpress ACF calendar plugin is based on Roee Yossef excellent article at 
<a href="https://he.savvy.co.il/blog/%D7%95%D7%95%D7%A8%D7%93%D7%A4%D7%A8%D7%A1/display-events-on-hebrew-calendar-wordpress/" target="_blank">`https://he.savvy.co.il/blog/%D7%95%D7%95%D7%A8%D7%93%D7%A4%D7%A8%D7%A1/display-events-on-hebrew-calendar-wordpress/`</a>.

## How to use

- Download this repo and install it on your Wordpress site 

- Install ACF Pro in order to use it.

- Import the file acf-export-2019-08-20.json (in the plugin root) into ACF to create the fields needed for the calendar.

הסבר קצר איך להתקין את התוסף מגיטהאב.
ראשית, קחו בחשבון שהתקנה של תוספים שלא מתוך הריפוזיטורי הרשמי של וורדפרס היא דבר לא רצוי. אני מציין את זה למרות שזה בניגוד לשיתוף של הקוד שאני מציע כי זה נושא חשוב ביותר.
מעבר לכך אין כל אחריות על הקוד מצידי. בבדיקות שלי הוא עובד יפה מאוד אבל ההתקנה היא באחריותך בלבד.

התקנה:
1.	יש להתקין ACF PRO באתר שלך
2.	להוריד את התוסף מגיטהאב למחשב שלך כקובץ ZIP
3.	לשנות את שם הקובץ שהורדת ל heb-calendar.zip
4.	בממשק הניהול באתר שלך תוספים -> הוספת תוסף -> העלאת תוסף
5.	העלה את הקובץ והתקן
6.	הפעל את התוסף

יצירת השדות 
1.	חלץ את הקובץ acf-export-2019-08-20.json מקובץ הזיפ שהורדתושמור במחשב
2.	בניהול האתר -> שדות מיוחדים -> כלים -> יבוא קבוצת שדות 
בחר את הקובץ וייבא אותו. זה ייצור את השדות המתאימים

קוד בדף
בדף שבו בחרת להציב את לוח השנה הכנס את הקוד הבא
 
 
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