<script type="text/javascript">
	/**
	 * Set predefined time period in "Most busy triggers top 100" page filter.
	 *
	 * @param int period
	 */
	function setPeriod(period) {
		var date = new Date(),
			newPeriod = [];

		switch (period) {
			case <?php echo REPORT_PERIOD_TODAY; ?>:
				newPeriod = {
					'fromYear': date.getFullYear(),
					'fromMonth': date.getMonth() + 1,
					'fromDay': date.getDate(),
					'tillYear': date.getFullYear(),
					'tillMonth': date.getMonth() + 1,
					'tillDay': date.getDate() + 1
				}
				break;

			case <?php echo REPORT_PERIOD_YESTERDAY; ?>:
				date.setTime(date.getTime() - <?php echo SEC_PER_DAY; ?> * 1000);

				newPeriod = {
					'fromYear': date.getFullYear(),
					'fromMonth': date.getMonth() + 1,
					'fromDay': date.getDate(),
					'tillYear': date.getFullYear(),
					'tillMonth': date.getMonth() + 1,
					'tillDay': date.getDate() + 1
				}
				break;

			case <?php echo REPORT_PERIOD_CURRENT_WEEK; ?>:
				var weekBegin = date.getTime() - (date.getDay() - 1) * <?php echo SEC_PER_DAY; ?> * 1000,
					weekEnd = weekBegin + <?php echo SEC_PER_DAY; ?> * 1000 * 7,
					dateFrom = new Date(date.setTime(weekBegin)),
					dateTill = new Date(date.setTime(weekEnd));

				newPeriod = {
					'fromYear': dateFrom.getFullYear(),
					'fromMonth': dateFrom.getMonth() + 1,
					'fromDay': dateFrom.getDate(),
					'tillYear': dateTill.getFullYear(),
					'tillMonth': dateTill.getMonth() + 1,
					'tillDay': dateTill.getDate()
				}
				break;

			case <?php echo REPORT_PERIOD_CURRENT_MONTH; ?>:
				newPeriod = {
					'fromYear': date.getFullYear(),
					'fromMonth': date.getMonth() + 1,
					'fromDay': '1',
					'tillYear': date.getFullYear(),
					'tillMonth': date.getMonth() + 2,
					'tillDay': '1'
				}
				break;

			case <?php echo REPORT_PERIOD_CURRENT_YEAR; ?>:
				newPeriod = {
					'fromYear': date.getFullYear(),
					'fromMonth': '1',
					'fromDay': '1',
					'tillYear': date.getFullYear() + 1,
					'tillMonth': '1',
					'tillDay': '1'
				}
				break;

			case <?php echo REPORT_PERIOD_LAST_WEEK; ?>:
				var lastWeekBegin = date.getTime() + ( - date.getDay() - 6) * <?php echo SEC_PER_DAY; ?> * 1000,
					lastWeekEnd = lastWeekBegin + <?php echo SEC_PER_DAY; ?> * 1000 * 7,
					dateFrom = new Date(date.setTime(lastWeekBegin)),
					dateTill = new Date(date.setTime(lastWeekEnd));

				newPeriod = {
					'fromYear': dateFrom.getFullYear(),
					'fromMonth': dateFrom.getMonth() + 1,
					'fromDay': dateFrom.getDate(),
					'tillYear': dateTill.getFullYear(),
					'tillMonth': dateTill.getMonth() + 1,
					'tillDay': dateTill.getDate()
				}
				break;

			case <?php echo REPORT_PERIOD_LAST_MONTH; ?>:
				if (date.getMonth() == 0) {
					// 11 month is december
					date = new Date(date.getFullYear() - 1, 11, 31);
				}
				else {
					date = new Date(date.getFullYear(), date.getMonth() - 1,
						daysInMonth(date.getFullYear(), date.getMonth() - 1)
					);
				}

				newPeriod = {
					'fromYear': date.getFullYear(),
					'fromMonth': date.getMonth() + 1,
					'fromDay': '1',
					'tillYear': date.getFullYear(),
					'tillMonth': date.getMonth() + 2,
					'tillDay': '1'
				}
				break;

			case <?php echo REPORT_PERIOD_LAST_YEAR; ?>:
				newPeriod = {
					'fromYear': date.getFullYear() - 1,
					'fromMonth': '1',
					'fromDay': '1',
					'tillYear': date.getFullYear(),
					'tillMonth': '1',
					'tillDay': '1'
				}
				break;

			default:
				newPeriod = {
					'fromYear': date.getFullYear(),
					'fromMonth': date.getMonth() + 1,
					'fromDay': date.getDate(),
					'tillYear': date.getFullYear(),
					'tillMonth': date.getMonth() + 1,
					'tillDay': date.getDate() + 1
				}
		}

		updatePeriod(newPeriod);
	}

	/**
	 * Update filter form, set new period in the filter input fields.
	 *
	 * @param int data['fromYear']	from year
	 * @param int data['fromMonth']	from month
	 * @param int data['fromDay']	from day
	 * @param int data['tillYear']	till year
	 * @param int data['tillMonth']	till month
	 * @param int data['tillDay']	till day
	 */
	function updatePeriod(data) {
		// append zeroes
		data.fromMonth = appendZero(data.fromMonth);
		data.fromDay = appendZero(data.fromDay);
		data.tillMonth = appendZero(data.tillMonth);
		data.tillDay = appendZero(data.tillDay);

		// from
		jQuery('#filter_from_year').val(data.fromYear);
		jQuery('#filter_from_month').val(data.fromMonth);
		jQuery('#filter_from_day').val(data.fromDay);
		jQuery('#filter_from_hour').val('00');
		jQuery('#filter_from_minute').val('00');

		// till
		jQuery('#filter_till_year').val(data.tillYear);
		jQuery('#filter_till_month').val(data.tillMonth);
		jQuery('#filter_till_day').val(data.tillDay);
		jQuery('#filter_till_hour').val('00');
		jQuery('#filter_till_minute').val('00');

		// filter data
		jQuery('#filter_from').val(data.fromYear+''+data.fromMonth+''+data.fromDay+'000000');
		jQuery('#filter_till').val(data.tillYear+''+data.tillMonth+''+data.tillDay+'000000');
	}
</script>
