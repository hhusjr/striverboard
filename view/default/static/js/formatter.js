function formatDay(time) {
    var time = new Date(time * 1000);
    return (time.getMonth() + 1) + '月' + time.getDate() + '日' + time.getHours() + '时' + time.getMinutes() + '分';
}

function formatDistance(km) {
    if (km >= 1) return Math.floor(km * 100) / 100 + '公里';
    if (km < 0.1) return '100米内';
    return Math.floor(km * 1000) + '米左右';
}