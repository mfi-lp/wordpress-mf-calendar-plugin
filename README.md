# Wordpress MF Calendar Plugin

Markable calendar  plugin with administrator panel for wordpress content management system.  You can select days, mark them and put some links or descriptions for them.

## 1. Installation
Plugin is easy to install.
1. Download the repository
2. Unzip the zip.
3. Upload the unzipped directory to wp-content/plugins folder of your wordpress (or, login the admin panel of your wordpress, select *Plugins*,  click *Add New* button, then click *Install Plugin*. Choose the unzipped directory.).
4. Activate it.

## 2. Moderate
You can moderate the plugin via administrator panel of wordpress easily.
1. Select Settings.
2. Choose MF Calendar.
3. Enter the inputs (Attention, date format should be DD/MM/YYYY!).
4. If you want to delete any of them, choose the Delete checkbox.
5. To edit any of them, you can directly change the value.

## 3. Usage
If you want to show the calendar into your wordpress pages. In this version, you have to style it and embed the code wordpress by yourself. 
```
#!php
<?php
get_mf_calendar_all_days(); // Return all the days of calender you marked in array format.
get_mf_calendar_all_links(); // Return all the links of calender you marked in array format. 
get_mf_calendar_all_descriptions(); // Return all the descriptions of calender you marked in array format.
?>
```