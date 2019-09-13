<template>
    <div id="myFilter">
        <md-toolbar>
            <div class="md-toolbar-section-start">
                <h3 class="md-title" style="color: ghostwhite;">Filter</h3>
                {{ this.f_f.daterange}}
            </div>
            <div class="md-toolbar-section-end">
                <md-button class="md-icon-button md-accent" @click="reset()">
                    <md-icon style="color: ghostwhite">settings_backup_restore</md-icon>
                    <md-tooltip md-direciton="left">Reset Filter</md-tooltip>
                </md-button>
                <md-button class="md-icon-button md-accent" @click="close()">
                    <md-icon style="color: ghostwhite">close</md-icon>
                </md-button>
            </div>
        </md-toolbar>

        <md-card class="md-layout-item">
            <md-card-content>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item">
                        <md-field>
                            <label for="pic">PIC</label>
                            <md-select id="pic" class="putih" v-model="f_f.pic" @input="fcoba()">
                                <md-option value="semua">Semua</md-option>
                                <md-option v-for="i in pic_js" :value="i.pic_nama" v-bind:key="i.pic_id">
                                    {{ i.pic_nama }} - {{ i.pic_divisi }}
                                </md-option>
                            </md-select>
                        </md-field>
                    </div>
                    <div class="md-layout-item">
                        <md-field>
                            <label for="kategori">Kategori</label>
                            <md-select id="kategori" v-model="f_f.kategori" @input="fcoba()">
                                <md-option value="semua">Semua</md-option>
                                <md-option v-for="i in kategori_kat" :value="i.kategori_nama"
                                    v-bind:key="i.kategori_id">
                                    {{ i.kategori_nama }}
                                </md-option>
                            </md-select>
                        </md-field>
                    </div>
                    <div class="md-layout-item">
                        <md-field>
                            <label for="prioritas" class="putih">Prioritas</label>
                            <md-select id="prioritas" v-model="f_f.prio" @input="fcoba()">
                                <md-option value="semua">Semua</md-option>
                                <md-option v-for="i in prio_js" :value="i.prioritas_nama" v-bind:key="i.prioritas_id">
                                    {{ i.prioritas_nama }}
                                </md-option>
                            </md-select>
                        </md-field>
                    </div>
                    <div class="md-layout-item">
                        <md-field>
                            <label for="status">Status</label>
                            <md-select id="status" v-model="f_f.status" @input="fcoba()">
                                <md-option value="semua">Semua</md-option>
                                <md-option v-for="i in stat_js" :value="i.stat_nama" v-bind:key="i.stat_id">
                                    {{ i.stat_nama }}
                                </md-option>
                            </md-select>
                        </md-field>
                    </div>
                    <div class="md-layout-item">
                        
                    </div>
                </div>
            </md-card-content>
        </md-card>
        <v-md-date-range-picker @change="hDR"></v-md-date-range-picker>
    </div>
</template>

<script>
 import axios from 'axios'
 import { mapState, mapActions } from 'vuex'
 export default {
     name: 'myFilter',
     props:{
         lb: String
     },
     data: () =>({
       f_f:{
         pic: 'semua',
         kategori: 'semua',
         prio: 'semua',
         status: 'selesai',
         daterange: '',
         lb: null,
         ub: null
       },
       tes: ''
     }),
     computed: {
       ...mapState([
         'stat_js',
         'kategori_kat',
         'prio_js',
         'pic_js',
         'filter',
       ])
     },
     created() {
     }, 
     mounted() {
         this.setFilter()
     },
     methods: {
       ...mapActions([
         'filter_n',
         'statFil',
         'picFil',
         'katFil',
         'prioFil',
         'lbFil',
         'ubFil'
       ]),
       fcoba(){
         this.statFil(this.f_f.status)
         this.picFil(this.f_f.pic)
         this.katFil(this.f_f.kategori)
         this.prioFil(this.f_f.prio)
         this.lbFil(this.f_f.lb)
         this.ubFil(this.f_f.ub)
         console.log(this.f_f.ub + 'ub')
         console.log(this.f_f.lb + 'lb')
         this.filter_n() 
       },
       setFilter(){
         this.f_f.status = this.filter.status
         this.f_f.pic = this.filter.pic
         this.f_f.kategori = this.filter.kategori
         this.f_f.prio = this.filter.prio
         this.f_f.daterange = null
       },
       refresh() {
         this.$emit('refresh')
       },
       close() {
         this.$emit('close')
       },
       reset(){
           console.log('reset filter')
           this.setFilter()
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
            this.f_f.daterange = CDate(res[0]) + "dan" + CDate(res[1])
            this.f_f.lb = res[0]
            this.f_f.ub = res[1]
            this.fcoba()  
       }
     }
 }
</script>
<style lang="scss" scoped>
  @import "~vue-material/dist/theme/engine"; // Import the theme engine
    @include md-register-theme("default", (
        primary: #0a3d62, // The primary color of your brand
        accent: #b71540 // The secondary color of your brand
    ));
    @import "~vue-material/dist/theme/all"; // Apply the theme
  .md-progress-bar {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
  }
  .md-dialog {
        min-width: 40vw;
        min-height: 100vh;
    }
    small {
        display: blok;
    }
    .md-dialog {
        max-width: 768px;
    }
    .md-toolbar.md-theme-default {
        background-color: #3c6382;
    }
    .md-toolbar.md-theme-default.md-transparent {
        background-color: #3c6382;
    }
    .f-w {
        color: #ffffff;
    }
</style>