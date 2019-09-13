import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import VueAxios from 'vue-axios' ;




Vue.use(Vuex);
Vue.use(VueAxios, axios);

const toLower = text => {
  return text.toString().toLowerCase()
}
const CDate = date => {
  if(!date){
      return new Date().getTime()    
  }
  return new Date(date).getTime()
}

function filterall() {    
  const picFilter = entry =>
      (store.state.filter.pic == 'semua') ||
      (entry.pic_nama === store.state.filter.pic);
  const katFilter = entry =>
      (store.state.filter.kategori == 'semua') ||
      (entry.kategori_nama === store.state.filter.kategori);
  const prioFilter = entry =>
      (store.state.filter.prio == 'semua') ||
      (entry.prioritas_nama === store.state.filter.prio);
  const statFilter = entry =>
      (store.state.filter.status == 'semua') ||
      (entry.stat_nama === store.state.filter.status);
  const datedFilter = entry =>
      (store.state.filter.lb == null) ||
      (CDate(entry.created_at) >= CDate(store.state.filter.lb));
  const datesFilter = entry =>
      (store.state.filter.ub == null) ||
      (CDate(entry.created_at) <= CDate(store.state.filter.ub));
  const reducer = (accumulator, entry) => {
      if ( picFilter(entry) && katFilter(entry) && prioFilter(entry) && statFilter(entry) && datedFilter(entry) && datesFilter(entry))
          accumulator.push(entry);
      return accumulator;
  }
  if (store.state.filter.pengirim){
      return store.state.tiket.reduce(reducer, []).filter(item => toLower(item.diajukan_oleh).includes(toLower(store.state.filter.pengirim)));
  }
  return store.state.tiket.reduce(reducer, []);
}  

export const store = new Vuex.Store({
  state: {
    tiket: [],
    tiket_filter: [],
    stat_js: [],
    kategori_kat: [],
    pic_js: [],
    prio_js: [],
    filter:{
      pic:'semua',
      kategori:'semua',
      prio:'semua',
      status:'semua',
      lb: null,
      ub: null,
      pengirim:'',
    },
    loading: true,
    tes: []

    },
    actions: {
      getTiket({commit}){
        axios
        .get('api/ticket')
        .then(res => {
          commit('SET_TIKET', res.data.data)
        })
        console.log('ambil data mentah')
      },
      getDataJS({commit}){
        axios
        .get('api/stat')
        .then(res => {
          commit('SET_STAT_JS', res.data.data)
        })
        axios
        .get('api/kat')
        .then(res => {
          commit('SET_KAT_JS', res.data.data)
        })
        axios
        .get('api/pic')
        .then(res => {
          commit('SET_PIC_JS', res.data.data)
        })
        axios
        .get('api/pri')
        .then(res => {
          commit('SET_PRIO_JS', res.data.data)
        })
      },
      //buat filter
      namaFil({commit}, p_pengirim){
        commit('FILTER_PENGIRIM', p_pengirim)
      },
      statFil({commit}, p_stat){
        commit('FILTER_STATUS', p_stat)
      },
      picFil({commit}, p_pic){
        commit('FILTER_PIC', p_pic)
      },
      katFil({commit}, p_kat){
        commit('FILTER_KAT', p_kat)
      },
      prioFil({commit}, p_prio){
        commit('FILTER_PRIO', p_prio)
      },
      lbFil({commit}, p_lb){
        commit('FILTER_LB', p_lb)
      },
      ubFil({commit}, p_ub){
        commit('FILTER_UB', p_ub)
      },
      filter_n({commit}){
        setTimeout(() =>{
          console.log('ambil data filteran')
          commit('SET_FILTER', filterall())
          commit('tiket_loader', false)
        },1000)
      },
      reset_Fil({commit}){
        console.log('tes')
        commit('FILTER_PENGIRIM', '')
        commit('FILTER_STATUS', 'semua')
        commit('FILTER_PIC', 'semua')
        commit('FILTER_KAT', 'semua')
        commit('FILTER_PRIO', 'semua')
        commit('FILTER_LB', null)
        commit('FILTER_UB', null)
      }
      //
      
    },
    mutations: {
      SET_TIKET(state, tiket){
         state.tiket = tiket
      },
      tiket_loader(state, loading){
        state.loading = loading
      },
      //set data ddl
      SET_STAT_JS(state, stat_js){
        state.stat_js = stat_js
      },
      SET_KAT_JS(state, kategori_kat){
        state.kategori_kat = kategori_kat
      },
      SET_PIC_JS(state, pic_js){
        state.pic_js = pic_js
      },
      SET_PRIO_JS(state, prio_js){
        state.prio_js = prio_js
      },
      //buat filter
      FILTER_PENGIRIM(state, pengirim){
        state.filter.pengirim = pengirim
      },
      FILTER_STATUS(state, status){
        state.filter.status = status
      },
      FILTER_PIC(state, pic){
        state.filter.pic = pic
      },
      FILTER_KAT(state, kat){
        state.filter.kategori = kat
      },
      FILTER_PRIO(state, prio){
        state.filter.prio = prio
      },
      FILTER_LB(state, lb){
        state.filter.lb = lb
      },
      FILTER_UB(state, ub){
        state.filter.ub = ub
      },
      SET_FILTER(state, a){
        state.tiket_filter = a
      },
      //
      
    },
    getters: {

    }
})


