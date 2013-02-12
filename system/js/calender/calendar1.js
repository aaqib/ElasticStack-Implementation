	window.onload = function () {
		
	}
	function selectDate1(date) {
		document.getElementById('from').value = cal1.getFormatedDate("%d-%m-%Y",date);
		document.getElementById('calendar1').innerHTML = '';
		document.getElementById('calendar1').style.display = 'none';
		return true;
	}
	function selectDate2(date) {
		document.getElementById('to').value = cal1.getFormatedDate("%d-%m-%Y",date);
		document.getElementById('calendar2').innerHTML = '';
		document.getElementById('calendar2').style.display = 'none';
		return true;
	}
	function selectDate3(date) {
	
		oTmpDate	= cal1.getFormatedDate("%d-%m-%Y",date).split('-');
		if(parseInt(oTmpDate[0]) > 28)
		{
			alert('Date can not be greater than 28');
			document.getElementById('from').value	= '';
		}
		else
		{
			document.getElementById('from').value = cal1.getFormatedDate("%d-%m-%Y",date);
		}
		document.getElementById('calendar3').innerHTML = '';
		document.getElementById('calendar3').style.display = 'none';
		return true;
	}
	function showCalendar(k, skin) {
		var mCal;
		document.getElementById('calendar1').innerHTML = '';
		cal1 = new dhtmlxCalendarObject('calendar'+k, null, {isYearEditable: true});
		cal1.loadUserLanguage('en-us');
		cal1.setYearsRange(2000, 2050);
		cal1.setSkin(skin);
		cal1.setOnClickHandler(selectDate1);
		document.getElementById('calendar'+k).style.display = 'block';
	}
	function showCalendar1(k, skin) {
		var mCal;
		document.getElementById('calendar2').innerHTML = '';
		cal1 = new dhtmlxCalendarObject('calendar2', null, {isYearEditable: true});
		cal1.loadUserLanguage('en-us');
		cal1.setYearsRange(2000, 2050);
		cal1.setSkin(skin);
		cal1.setOnClickHandler(selectDate2);
		document.getElementById('calendar'+k).style.display = 'block';
	}
	function showCalendarCustom(k, skin) {
		var mCal;
		document.getElementById('calendar3').innerHTML = '';
		cal1 = new dhtmlxCalendarObject('calendar3', null, {isYearEditable: true});
		cal1.loadUserLanguage('en-us');
		cal1.setYearsRange(2000, 2050);
		cal1.setSkin(skin);
		cal1.setOnClickHandler(selectDate3);
		document.getElementById('calendar'+k).style.display = 'block';
	}

	function setup() {
		document.getElementById('Calendar').innerHTML = "";
		mCal = new dhtmlxCalendarObject('Calendar', false, {isYearEditable: true});
		mCal.loadUserLanguage('en-us');
		mCal.setYearsRange(2000, 2500);
		mCal.attachEvent ("onClick", mSelectDate);	
		mCal.draw();
		
	}
		function mSelectDate(date) {
		document.getElementById('from').value = mCal.getFormatedDate("%d/%m/%Y", date);
		document.getElementById('Calendar').innerHTML = "";
		return true;
	}

	
	function mSelectMonth(curMonth, prevMonth) {
		document.getElementById('mCalInput').innerHTML = 'Previous month # : ' + prevMonth + '<br /> Current month # ' + curMonth;
		return true;
	}