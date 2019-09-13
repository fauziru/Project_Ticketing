<template>
    <div id="tes">
        <div v-if="loading">
          <md-progress-spinner class="md-priemer" :md-stroke="3" md-mode="indeterminate"></md-progress-spinner>
          Loading . . .
        </div>
        <div v-else>
          <div v-bind:class="tesbindclass"></div>
        <md-switch v-model="boolean">Boolean</md-switch> 
        {{ this.boolean }}
          <div class="md-layout-item">
            <md-field md-clearable>
                <label for="pengirim">Pengirim</label>
                <md-input id="pengirim" placeholder="Pengirim ..." v-model="filter.pengirim" @input="fcoba()"/>
            </md-field>
        </div>
        <md-field>
            <label for="status">Status</label>
            <md-select id="status" v-model="filter.status" @input="fcoba()">
                <md-option value="semua">Semua</md-option>
                <md-option v-for="i in stat_js" :value="i.stat_nama" v-bind:key="i.stat_id">
                    {{ i.stat_nama }}
                </md-option>
            </md-select>
        </md-field>

        <v-md-date-range-picker @change="hDR"></v-md-date-range-picker>
        {{ this.filter.daterange }}

        <paginate ref="paginator"
          name="tiket_filter"
          :list="tiket_filter"
          :per="10"
        >
          <ul>
              <li v-for="i in paginated('tiket_filter')">
                  {{ i.diajukan_oleh }} - {{ i.created_at | cD }} - {{ i.deskripsi_masalah | isi }}
              </li>
          </ul>`
        </paginate>
        <paginate-links 
          for="tiket_filter" 
          :async="true"
          :show-step-links="true"
          :limit="3"
          :hide-single-page="true"
          ></paginate-links>
          <span v-if="$refs.paginator">
            {{$refs.paginator.pageItemsCount}}
          </span>
        <div>    
            {{ this.filter.pengirim }}
            <div>
            {{ this.filter.status }}
            </div>
            <md-button @click="fcoba()">tes</md-button>

        </div>

        </div>
        
    </div>
</template>

<script>
 import axios from 'axios'
 import { mapState, mapActions } from 'vuex'

 export default {
     name: 'tes',
     data: () =>({
       filter:{
         pic: 'semua',
         kategori: 'semua',
         prio: 'semua',
         status: 'semua',
         lb: null,
         ub: null,
         pengirim: '',
         daterange:''
       },
       tes: '',
       boolean: '',
       paginate: ['tiket_filter']
     }),
     computed: {
       ...mapState([
         'loading',
         'tiket_filter',
         'stat_js',
         'kategor_kat',
         'prio_js',
         'pic_js',
         'filter.pengirim',
         'filter.status'
       ]),
       tesbindclass: function(){
         return {
           toggleAktif : this.boolean
         }
       }
     },
     created() {
         this.getTiket()
         this.getDataJS()
         //ini buat fungsi filter
         this.filter_n()
     }, 
     methods: {
       ...mapActions([
         'getTiket',
         'getDataJS',
         'filter_n',
         'tes_fungsi',
         'namaFil',
         'statFil',
         'picFil',
         'katFil',
         'prioFil',
         'lbFil',
         'ubFil'
       ]),
       fcoba(){
         this.namaFil(this.filter.pengirim)
         this.statFil(this.filter.status)
         this.picFil(this.filter.pic)
         this.katFil(this.filter.kategori)
         this.prioFil(this.filter.prio)
         this.lbFil(this.filter.lb)
         this.ubFil(this.filter.ub)
         this.filter_n() 
       },
       hDR(val){
         var str = val.toString()
         var res = str.split(',')
         const CDate = date => {
            if(!date){
                return new Date().getTime()    
            }
            return new Date(date).getTime()
          }
         this.filter.daterange = CDate(res[0]) + "dan" + CDate(res[1])
       }
     }
 }
</script>