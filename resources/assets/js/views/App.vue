<template>
    <div id="app">
        <div>
            <md-dialog :md-active.sync="inputDialog">
                <formticket lb="Request Ticket" @refresh="getData()" @close="inputDialog = false"/>
            </md-dialog>
            <md-dialog :md-active.sync="editpicDialog">
                <formpic :req_id="req_id" lb="Pilih PIC" @refresh="getData()" @close="editpicDialog = false"/>
            </md-dialog>
            <md-dialog :md-active.sync="detailDialog">
                <detail  :req_id="req_id" :stat_id="stat_id" lb="Detail" @refresh="getData()" @close="detailDialog = false"/>
            </md-dialog>
            <div v-show="filterAccord">
                <filterForm ref="ada" lb="Filter"  @close="filterAccord = false"/>
            </div>
        </div>
        <!--filter-->
        <!--Accord-->
        <!-- paginate -->
        <div v-bind:class="toggle_tes"></div>
        <paginate ref="paginator"
            name="tiket_page"
            :list="tiket_filter"
            tag="div"
            :per="5"
            >
        <md-table v-model="tiket_" md-sort="name" md-sort-order="asc" md-card>
            <md-table-toolbar>
                <div class="md-tollbar-section-start">
                    <h3 class="md-title" style="color: ghostwhite;">Daftar Tiket Yang Masuk</h3>
                </div>
                <div class="md-toolbar-section-end" style="padding-left: 26vw;">
                        <div v-bind:class="toggle_tes"></div>
                        <md-button class="md-icon-button md-accent" @click="filterAccord = !filterAccord">
                            <md-icon style="color: ghostwhite" >filter_list</md-icon>
                            <md-tooltip md-direciton="left">Edit Filter acordion</md-tooltip>
                        </md-button>
                    <md-button class="md-icon-button md-accent" @click="reset()">
                        <md-icon style="color: ghostwhite">settings_backup_restore</md-icon>
                        <md-tooltip md-direciton="left">Reset Filter</md-tooltip>
                    </md-button>
                    <md-button class="md-icon-button md-accent" @click="tesdetail()">
                        <md-icon style="color: ghostwhite">error</md-icon>
                        <md-tooltip md-direciton="left">Tess debug</md-tooltip>
                    </md-button>
                    <md-button class="md-icon-button md-accent" @click="inputDialog = true">
                        <md-icon style="color: ghostwhite">add</md-icon>
                        <md-tooltip md-direciton="left">Tambah Ticket</md-tooltip>
                    </md-button>
                </div>
            </md-table-toolbar>
            <md-table-empty-state md-label="Tiket tidak temukan"
                :md-description="`Ticket dengan filter  pada query ini tidak temukan. Coba dengan kombinasi filter yang lain.`">
                <md-button class="md-primary md-raised" @click="ticketbaru">Buat request baru</md-button>
            </md-table-empty-state>
            <md-table-row slot="md-table-row" slot-scope="{item}">
                <md-table-cell md-label="Pengirim" md-sort-by="diajukan_oleh">{{ item.diajukan_oleh }}</md-table-cell>
                <md-table-cell md-label="Isi" md-sort-by="deskripsi_masalah">{{ item.deskripsi_masalah | isi }}</md-table-cell>
                <md-table-cell md-label="PIC" md-sort-by="pic_nama">
                    <div>
                        {{ item.pic_nama }}
                        <md-tooltip md-direction="bottom">Divisi : {{ item.pic_divisi }}</md-tooltip>
                    </div>
                </md-table-cell>
                <md-table-cell md-label="Kategori" md-sort-by="kategori_nama">{{ item.kategori_nama }}</md-table-cell>
                <md-table-cell md-label="Prioritas" md-sort-by="prioritas_nama">{{ item.prioritas_nama }}</md-table-cell>
                <md-table-cell md-label="Status" md-sort-by="stat_nama">{{ item.stat_nama }}</md-table-cell>
                <md-table-cell md-label="Diperbarui" md-sort-by="updated_at">
                    <div>
                        {{ item.updated_at | cD }}
                        <md-tooltip md-direction="bottom">Dibuat : {{ item.created_at }},
                            Diperbarui : {{ item.updated_at }}
                        </md-tooltip>
                    </div> 
                </md-table-cell>
                <md-table-cell class="" md-label="Aksi" md-sort-by="">
                    <md-button class="md-icon-button md-accent" v-on:click="detail(item.req_id, item.stat_id)">
                        <md-icon style="color: #eb2f06">visibility</md-icon>
                        <md-tooltip md-direction="bottom">Detail</md-tooltip>
                    </md-button>
                    <md-button class="md-icon-button md-accent" v-on:click="deltiket(item.req_id)">
                        <md-icon class="md-accent">delete</md-icon>
                        <md-tooltip md-direction="bottom">Hapus</md-tooltip>
                    </md-button>
                    <md-button :disabled="tidakaktif(item.stat_id)" class="md-icon-button md-accent" v-on:click="sudahtiket(item.req_id, item.stat_id)">
                        <md-icon :style="dis(item.stat_id)">done</md-icon>
                        <md-tooltip md-direction="bottom">{{ item.stat_id | bt }}</md-tooltip>
                    </md-button>
                </md-table-cell>
            </md-table-row>
        </md-table>
            </paginate>
            <div class="md-layout md-gutter">
                <div class="md-layout-item md-toolbar-section-start">
                    <span v-if="$refs.paginator" class="page-item">
                        {{$refs.paginator.pageItemsCount}}
                    </span>
                </div>
                <div class="md-layout-item md-toolbar-section-end">
                    <paginate-links 
                        for="tiket_page" 
                        tag="div"
                        :async="true"
                        :show-step-links="true"
                        :step-links="{
                            next: '>',
                            prev: 'chevron_left'
                        }"
                        :limit="2"
                        :hide-single-page="true"
                        :classes="{
                            'ul.paginate-links > li.number > a' : ['md-button','md-button-content','md-icon-button'],
                            'ul.paginate-links > li.ellipses > a' : ['md-button','md-button-content','md-icon-button'],
                            'ul.paginate-links > li.right-arrow > a' : [],
                            'ul.paginate-links > li.left-arrow > a' : ['md-button','md-icon', 'md-icon-font']
                        }"
                    ></paginate-links>
                    
                </div>
            </div>
        <!--paginate-->
        
        <md-snackbar :md-active.sync="notif_e" style="align: center;"> {{ notif }} </md-snackbar>
    </div>
</template>
<script>
    import HelloWorld from '../components/HelloWorld.vue'
    import formticket from '../components/formticket.vue'
    import formpic from '../components/formpic.vue'
    import detail from '../components/detail.vue'
    import filterForm from '../components/formfilter.vue'
    import tes from '../components/tes.vue'
    import axios from 'axios'
    import { mapState, mapActions } from 'vuex'
    export default {
      name: 'app',
      components: {
        HelloWorld,
        formticket,
        formpic,
        filterForm,
        detail,
        tes
      },
        data: () => ({
            status: "",
            search: "",
            editallDialog: false,
            editpicDialog: false,
            inputDialog: false,
            filterAccord: false,
            detailDialog: false,     
            tesDialog: false,
            notif_e: false,
            notif: [],
            req_id: 0,
            stat_id: 0,
            paginate: ['tiket_page']            
        }),
        computed: {
            ...mapState([
                'tiket',
                'loading',
                'stat_js',
                'tiket_filter',
                'filter'
            ]),
            toggle_tes: function () {
                return {
                    'md-toggle-active': this.filterAccord
                }
            },
            tiket_() {
                return this.paginated('tiket_page')
            },
        },
        created () { 
         this.getTiket()
         this.getDataJS()
         this.filter_n()
        },
        methods: {
        ...mapActions([
         'getTiket',
         'getDataJS',
         'filter_n',
         'tes_fungsi',
         'namaFil',
         'reset_Fil'
       ]),
       fcoba(){
         this.namaFil(this.filter.pengirim)
         this.filter_n() 
       },
            tidakaktif: function(event){
                switch(event){
                    case 3: return true
                    case 2: return false
                    case 1: return false
                }
            },
            dis: function(event){
               switch(event){
                   case 3: return 'rgba(0, 0, 0, 0.26)'
                   case 2: return 'color: #78e08f'
                   case 1: return 'color: #f6b93b'
               } 
            },
            actv: function(){
                console.log(this.filterAccord)
                const e = this.filterAccord
                switch(e){
                   case true: return{
                       'color: #b17540' : e
                   } 
                   break
                   case false : return{
                       'color: ghostwhite' : e
                   } 
                   break
               }
            },
            sudahtiket: function(event, stat_id){
                var stat_id = [stat_id]
                var b = [stat_id]
                if (b < 2) {
                    this.req_id = [event]
                    this.editpicDialog = true
                }else if (b < 3) {
                    var req = 'api/ticket/done/' + [event] 
                    axios
                    .put(req)
                    .then(response => (this.notif = response.data.message))
                    this.notif_e = true
                    this.getData()
                }
            },
            deltiket: function(event){
                var del = 'api/ticket/' + [event]
                axios
                .delete(del)
                .then(response => (this.notif = response.data.message))
                this.notif_e = true
                this.getData() 
            },
            detail: function(event, stat){
                this.req_id = event
                this.stat_id = stat
                this.detailDialog = true
            },
            ticketbaru() {
                this.inputDialog = true
            },
            reset() {
                //trigger method set filter di form filter component
                this.reset_Fil()
                this.filter_n()
                this.$refs.ada.reset()
            },
            getData() {
                this.getTiket()
                this.filter_n()
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
    .putih{
        color: ghostwhite;
    }
    .md-dialog {
        min-width: 40vw;
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
    .md-toggle-active{
        background-color: #b71540;
    }
       
</style>