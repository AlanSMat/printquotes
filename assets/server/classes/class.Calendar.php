<?php
/***************************/
/* Define Static variables */
/* used throughout the     */
/* application             */
/***************************/

class Calendar 
{
	public function __construct() 
	{
		$this->scripts();
	}
	
	private function scripts()
	{
		?>
		<link rel="stylesheet" href="<?php echo CSS_URL?>/calendar.css" type="text/css" />
		<!-- main calendar program -->
		<script type="text/javascript" src="<?php echo SCRIPTS_URL ?>/calendar/calendar.js"></script>
	
		<!-- language for the calendar -->
		<script type="text/javascript" src="<?php echo SCRIPTS_URL ?>/calendar/calendar-en.js"></script>
	
		<!-- the following script defines the Calendar.setup helper function, which makes
				 adding a calendar a matter of 1 or 2 lines of code. -->
	
		<script type="text/javascript" src="<?php echo SCRIPTS_URL ?>/calendar/calendar-setup.js"></script>
		<?php
	}

	public function input($input_name, $repop_value, $cal_id = "f_date_c")
	{
		?>
		<input type="text" class="textBox" size="15" name="<?php echo $input_name ?>" id="<?php echo $cal_id ?>" value="<?php echo $repop_value ?>" />
		<?php
	}	
	
	public function image($id = "f_trigger_c")
	{
		?>
		<img src="<?php echo IMAGES_URL?>/calendar/Calendar_scheduleHS.png" id="<?php echo $id ?>" style="cursor: pointer;" title="Date selector" />
		<?php
	}
	
	public function init($cal_id = "f_date_c", $trigger_id = "f_trigger_c") 
	{
		?>
		<script type="text/javascript">
        Calendar.setup({
            inputField     :    "<?php echo $cal_id ?>",     // id of the input field
            ifFormat       :    "%e %b %Y",      // format of the input field
            button         :    "<?php echo $trigger_id ?>",   // trigger for the calendar (button ID)
            align          :    "Tl",            // alignment (defaults to "Bl")
            singleClick    :    true
        });
    </script>    
    <?php
	}	
}

?>