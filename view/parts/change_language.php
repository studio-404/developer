<div class="dropdown">
    <?=$data["language_select"]?>
</div>
<div class="widget" id="widget" title="session time out">			
	<div class="time-text">
		<span class="time-number"><?=date("s")?></span>
		<span class="time-caption">Sec</span>
	</div><span class="time-separator">:</span>
	<div class="time-text">
		<span class="time-number"><?=date("i")?></span>
		<span class="time-caption">Min</span>
	</div><span class="time-separator">:</span>
	<div class="time-text">
		<span class="time-number"><?=date("H")?></span>
		<span class="time-caption">Hour</span>
	</div>
</div>
<div class="clearfix"></div>