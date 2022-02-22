export default {
    F(){
        var f = eval(arguments[0]);
        arguments.splice = [].splice;
        var p = arguments.splice(1);
        return f.apply(this, p);
    },

    //层级格式化
    deep(num){
        var str = '|';
        for (var i = 1; i < num; ++i) {
            str += '—';
        }
        if (num > 1) {
            return str + ':';
        }
        return '';
    },
    //小数经度丢失处理
    parse_float(num){
        return parseFloat((num).toPrecision(12));
    },
    //金额格式化
    currency(num, digit, prefix){
        if (typeof digit == 'undefined') {
            digit = 0;
        }
        if (typeof prefix == 'undefined') {
            prefix = '¥';
        }
        return prefix + Number(num).toFixed(digit);
    },
    pow_opposite(num, cardinal_number){
        return Math.log(num) / Math.log(cardinal_number);
    },
    checkbox_class(num, cardinal_number, statusClass){
        return 'label-' + statusClass[(Math.log(num) / Math.log(cardinal_number) + 1) % statusClass.length];
    },
    birthday(date, def){
        if (!def) {
            def = '';
        }
        if (!date) {
            return def;
        }
        return date.substr(0, 4) +'年'+date.substr(5, 2) + '月' + date.substr(8, 2) + '日';
    },
    number_format(number, decimals, dec_point, thousands_sep){
        number = (number + '').replace(/[^0-9+-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.ceil(n * k) / k;
            };

        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        var re = /(-?\d+)(\d{3})/;
        while (re.test(s[0])) {
            s[0] = s[0].replace(re, "$1" + sep + "$2");
        }

        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    },

    in_array(find, arr){
        return collect(arr).contains(find);
    },
    random_string(length){
        var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var result = '';
        for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
        return result;
    }
}
