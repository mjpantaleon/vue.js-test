export default {
    gender(v){
        if(!v){
            return '';
        }

        return v == 'M' ? 'Male' : 'Female';
    },
    mhpe(v){
        switch(v){
            case 'A': return 'Accepted'; break;
            case 'TD': return 'Temporary Deferred'; break;
            case 'PD': return 'Permanently Deferred'; break;
            case 'ID': return 'Indifinitely Deferred'; break;
            default: return '';
        }
    },
    collection(v){
        return v == 'COL' ? 'Successful' : 'Unsuccessful';
    },
    abbrev(v){
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
    },
    collection(v){
        switch(v.toUpperCase()){
            case 'COL': return 'Successful'; break;
            case 'UNS': return 'Unsuccessful'; break;
            default: return '';
        }
    },
    donationStatus(v){
        switch(v.toUpperCase()){
            case 'Y' : return 'May Donate'; break;
            case 'N' : return 'Cannot Donate'; break;
            default: return 'May Donate';
        }
    },
    gender(v){
        switch(v.toUpperCase()){
            case 'M' : return 'Male'; break;
            case 'F' : return 'Female'; break;
            default: return '';
        }
    }
}