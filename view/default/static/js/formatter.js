function formatDay(time) {
    var time = new Date(time * 1000);
    return (time.getMonth() + 1) + '月' + time.getDate() + '日' + time.getHours() + '时' + time.getMinutes() + '分';
}

function formatDistance(km) {
    if (km >= 1) return Math.floor(km * 100) / 100 + '公里';
    if (km < 0.1) return '100米内';
    return Math.floor(km * 1000) + '米左右';
}

function htmlspecialchars(value) {
    return $s('<div />').text(value).html();
}

// implements Java's str.hashCode
String.prototype.hashCode = function() {
    var hash = 0;
    var i, chr;
    if (this.length === 0) return hash;
    for (i = 0; i < this.length; i++) {
        chr = this.charCodeAt(i);
        hash = ((hash << 5) - hash) + chr;
        hash |= 0;
    }
    return hash;
};