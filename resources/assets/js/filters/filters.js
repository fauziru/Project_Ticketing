import Vue from 'vue';

const CDate = date => {
    if(!date){
        return new Date().getTime()    
    }
    return new Date(date).getTime()
  }

  Vue.filter('cD', function(t){
    var dift_s = (CDate() - CDate(t))/1000 
    var dift_d = Math.floor(dift_s/86400) 
    switch(true){
        case (dift_d == 0): 
            switch(true){
                case (dift_s < 10): return "Baru Saja"
                case (dift_s < 60): return Math.floor(dift_s) + " Detik yang lalu"
                case (dift_s < 3600): return Math.floor(dift_s/ 60) + " Menit yang lalu"
                case (dift_s < 86400): return Math.floor(dift_s/ 3600) + " Jam yang lalu"
            } 
        case (dift_d == 1): return "Kemarin"  
        case (dift_d < 7): return dift_d + " Hari yang lalu"
        case (dift_d < 31): return Math.floor(dift_d/ 7) + " Minggu yang lalu"
        case (dift_d < 365): return Math.floor(dift_d/ 31) + " Bulan yang lalu"
        case (dift_d > 365): return Math.floor(dift_d/ 365) + " Tahun yang lalu"
    }       
  })

  Vue.filter('isi', function(dm){
    var hasil = dm.substring(0,10) + ' ...' 
    return hasil
  })

  Vue.filter('bt', function(id){
    switch(id){
        case 1: return "Pillih PIC"
        case 2: return "Selesai"
        case 3: return "!"
    }
  })