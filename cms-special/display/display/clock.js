setInterval(() => {
    date = new Date()
    hours = date.getHours()
    minutes = date.getMinutes()
    day = date.getDate()
    weekday = date.getDay()
    month = date.getMonth()

    if (hours < 10) {
        hstr = "0" + hours;
    } else {
        hstr = hours;
    }

    if (minutes < 10) {
        minstr = "0" + minutes;
    } else {
        minstr = minutes;
    }

    if (day == 1) {
        daystr = "1er"
    } else {
        daystr = day
    }

    if (weekday == 1) {
        weekdaystr = "lun."
    }

    if (weekday == 2) {
        weekdaystr = "mar."
    }

    if (weekday == 3) {
        weekdaystr = "mer."
    }

    if (weekday == 4) {
        weekdaystr = "jeu."
    }

    if (weekday == 5) {
        weekdaystr = "ven."
    }

    if (weekday == 6) {
        weekdaystr = "sam."
    }

    if (weekday == 0) {
        weekdaystr = "dim."
    }

    if (month == 0) {
        monthstr = "janv."
    }

    if (month == 1) {
        monthstr = "févr."
    }

    if (month == 2) {
        monthstr = "mars"
    }

    if (month == 3) {
        monthstr = "avr."
    }

    if (month == 4) {
        monthstr = "mai"
    }

    if (month == 5) {
        monthstr = "juin"
    }

    if (month == 6) {
        monthstr = "juil."
    }

    if (month == 7) {
        monthstr = "août"
    }

    if (month == 8) {
        monthstr = "sept."
    }

    if (month == 9) {
        monthstr = "oct."
    }

    if (month == 10) {
        monthstr = "nov."
    }

    if (month == 11) {
        monthstr = "déc."
    }

    document.getElementById('clock-time').innerHTML = hstr + ":" + minstr
    document.getElementById('clock-date').innerHTML = weekdaystr + " " + daystr + " " + monthstr
}, 1000)