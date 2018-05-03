import Vue from 'vue';

Vue.filter("gender", v => {
    if(!v){
        return '';
    }
    
    return v == 'M' ? 'Male' : 'Female';
});

Vue.filter("mhpe", v => {
    switch(v){
        case 'A': return 'Accepted'; break;
        case 'TD': return 'Temporary Deferred'; break;
        case 'PD': return 'Permanently Deferred'; break;
        case 'ID': return 'Indifinitely Deferred'; break;
        default: return '';
    }
});

Vue.filter("collection", v => {
    if(!v){
        return '';
    }
    switch(v.toUpperCase()){
        case 'COL': return 'Successful'; break;
        case 'UNS': return 'Unsuccessful'; break;
        default: return '';
    }
});

Vue.filter("abbrev", v => {
    if(v.toUpperCase() == 'CRYOPRECIPITATE'){
        return 'CRYOP';
    }
    if(v.toUpperCase() == 'CRYOSUPERNATE'){
        return 'CRYOS';
    }
    let x = v.split(' ');
    let o = [];
    x.forEach((z) => {
        o.push(z.substr(0,1))
    });
    return o.join('');
});

Vue.filter("collection_method", v => {
    if(!v){
        return '';
    }
    switch(v.toUpperCase()){
        case 'WB': return 'WHOLE BLOOD'; break;
        case 'P': return 'PHERESIS'; break;
        default: return '';
    }
});

Vue.filter("donationStatus", v => {
    if(!v){
        return '';
    }
    switch(v.toUpperCase()){
        case 'Y' : return 'May Donate'; break;
        case 'N' : return 'Cannot Donate'; break;
        default: return 'May Donate';
    }
});

Vue.filter("gender", v => {
    if(!v){
        return '';
    }
    switch(v.toUpperCase()){
        case 'M' : return 'Male'; break;
        case 'F' : return 'Female'; break;
        default: return '';
    }
});

Vue.filter("civilStatus", v => {
    if(!v){
        return '';
    }
    switch(v.toUpperCase()){
        case 'S' : return 'Single'; break;
        case 'M' : return 'Married'; break;
        case 'SP' : return 'Separated'; break;
        case 'W' : return 'Widowed'; break;
        default: return '';
    }
});

Vue.filter("donationType", v => {
    if(!v){
        return '';
    }
    switch(v.toUpperCase()){
        case 'A' : return 'AUTOLOGOUS'; break;
        case 'P' : return 'PAID'; break;
        case 'R' : return 'FAMILY / REPLACEMENT'; break;
        case 'V' : return 'VOLUNTARY'; break;
        default: return '';
    }
});

Vue.filter("novalue", (o,p) => {
    if(!o){
        return '';
    }
    return o[p] ? o[p] : '';
});

Vue.filter("nye", v => {
    return v.replace('??','Ñ').replace('Â','Ñ');
});

Vue.filter("age", v => {
    let birthday = Date.parse(v);
    let age = ~~((Date.now() - birthday) / (31557600000));
    return age;
});

Vue.filter("uppercase", v => {
    return v ? v.toUpperCase() : '';
});

Vue.filter("date-today", v => {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd = '0'+dd
    } 

    if(mm<10) {
        mm = '0'+mm
    } 

    today = yyyy + '-' + mm + '-' + dd;
    return today;
})