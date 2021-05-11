<template>
    <div class="language">
        <el-dropdown @command="changeVal" trigger="click">
            <div ref="view">
                <div class="country" v-if="val">
                    <div class="flag" :class="country"></div>
                </div>
                <i class="fa fa-globe" v-else></i>
                <span class="country-name">{{country_name || $t('Language')}}</span>
            </div>
            <el-dropdown-menu slot="dropdown">
                <el-dropdown-item :command="item.value" v-for="(item,index) in _languages" v-bind:key="index">
                    <div class="country">
                        <div class="flag" :class="item.country"></div>
                    </div>
                    <span class="country-name">{{item.name}} {{item.en_name}}</span>
                </el-dropdown-item>
            </el-dropdown-menu>
        </el-dropdown>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    export default {
        name: "language",
        components:{
            "el-dropdown": ()=>import(/* webpackChunkName: "element-ui/lib/dropdown" */ 'element-ui/lib/dropdown'),
            "el-dropdown-menu": ()=>import(/* webpackChunkName: "element-ui/lib/dropdown-menu" */ 'element-ui/lib/dropdown-menu'),
            "el-dropdown-item": ()=>import(/* webpackChunkName: "element-ui/lib/dropdown-item" */ 'element-ui/lib/dropdown-item'),
        },
        props: {
            value:{
                default() {
                    return '';
                }
            },
        },
        data: function () {
            return {
                val:this.value,
                languages:[
                    {
                        value:"zh-CN",
                        name:"中国",
                        en_name:"China",
                        country:"cn",
                    },
                    {
                        value:"zh-TW",
                        name: "中國(台灣)",
                        en_name:"China (Taiwan)",
                        country: "tw",
                    },
                    {
                        value:"zh-HK",
                        name: "中國(香港)",
                        en_name:"China (Hong Kong)",
                        country: "hk",
                    },
                    {
                        value:"en",
                        name:"English",
                        en_name:"Britain",
                        country:"gb",
                    },
                    {
                        value:"ja",
                        name: "日本",
                        country: "jp",
                        en_name:"Japan"
                    },
                    {
                        value:"ko",
                        name: "대한민국",
                        country: "kr",
                        en_name:"South Korea"
                    },
                    {
                        value:"fr",
                        name: "La France",
                        en_name: "France",
                        country: "fr"
                    },
                    {
                        value:"ru",
                        name: "Россия",
                        en_name: "Russia",
                        country: "ru"
                    },
                    {
                        value:"es",
                        name: "España",
                        en_name: "Spain",
                        country: "es"
                    },
                    {
                        value:"pt",
                        name: "Portugal",
                        en_name: "Portugal",
                        country: "pt"
                    }

                ],
             /*   countries_reference:[
                    {
                    name: "Afghanistan (‫افغانستان‬‎)",
                    country: "af"
                }, {
                    name: "Åland Islands (Åland)",
                    country: "ax"
                }, {
                    name: "Albania (Shqipëri)",
                    country: "al"
                }, {
                    name: "Algeria (‫الجزائر‬‎)",
                    country: "dz"
                }, {
                    name: "American Samoa",
                    country: "as"
                }, {
                    name: "Andorra",
                    country: "ad"
                }, {
                    name: "Angola",
                    country: "ao"
                }, {
                    name: "Anguilla",
                    country: "ai"
                }, {
                    name: "Antarctica",
                    country: "aq"
                }, {
                    name: "Antigua and Barbuda",
                    country: "ag"
                }, {
                    name: "Argentina",
                    country: "ar"
                }, {
                    name: "Armenia (Հայաստան)",
                    country: "am"
                }, {
                    name: "Aruba",
                    country: "aw"
                }, {
                    name: "Australia",
                    country: "au"
                }, {
                    name: "Austria (Österreich)",
                    country: "at"
                }, {
                    name: "Azerbaijan (Azərbaycan)",
                    country: "az"
                }, {
                    name: "Bahamas",
                    country: "bs"
                }, {
                    name: "Bahrain (‫البحرين‬‎)",
                    country: "bh"
                }, {
                    name: "Bangladesh (বাংলাদেশ)",
                    country: "bd"
                }, {
                    name: "Barbados",
                    country: "bb"
                }, {
                    name: "Belarus (Беларусь)",
                    country: "by"
                }, {
                    name: "Belgium (België)",
                    country: "be"
                }, {
                    name: "Belize",
                    country: "bz"
                }, {
                    name: "Benin (Bénin)",
                    country: "bj"
                }, {
                    name: "Bermuda",
                    country: "bm"
                }, {
                    name: "Bhutan (འབྲུག)",
                    country: "bt"
                }, {
                    name: "Bolivia",
                    country: "bo"
                }, {
                    name: "Bosnia and Herzegovina (Босна и Херцеговина)",
                    country: "ba"
                }, {
                    name: "Botswana",
                    country: "bw"
                }, {
                    name: "Bouvet Island (Bouvetøya)",
                    country: "bv"
                }, {
                    name: "Brazil (Brasil)",
                    country: "br"
                }, {
                    name: "British Indian Ocean Territory",
                    country: "io"
                }, {
                    name: "British Virgin Islands",
                    country: "vg"
                }, {
                    name: "Brunei",
                    country: "bn"
                }, {
                    name: "Bulgaria (България)",
                    country: "bg"
                }, {
                    name: "Burkina Faso",
                    country: "bf"
                }, {
                    name: "Burundi (Uburundi)",
                    country: "bi"
                }, {
                    name: "Cambodia (កម្ពុជា)",
                    country: "kh"
                }, {
                    name: "Cameroon (Cameroun)",
                    country: "cm"
                }, {
                    name: "Canada",
                    country: "ca"
                }, {
                    name: "Cape Verde (Kabu Verdi)",
                    country: "cv"
                }, {
                    name: "Caribbean Netherlands",
                    country: "bq"
                }, {
                    name: "Cayman Islands",
                    country: "ky"
                }, {
                    name: "Central African Republic (République Centrafricaine)",
                    country: "cf"
                }, {
                    name: "Chad (Tchad)",
                    country: "td"
                }, {
                    name: "Chile",
                    country: "cl"
                }, {
                    name: "China (中国)",
                    country: "cn"
                }, {
                    name: "Christmas Island",
                    country: "cx"
                }, {
                    name: "Cocos (Keeling) Islands (Kepulauan Cocos (Keeling))",
                    country: "cc"
                }, {
                    name: "Colombia",
                    country: "co"
                }, {
                    name: "Comoros (‫جزر القمر‬‎)",
                    country: "km"
                }, {
                    name: "Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)",
                    country: "cd"
                }, {
                    name: "Congo (Republic) (Congo-Brazzaville)",
                    country: "cg"
                }, {
                    name: "Cook Islands",
                    country: "ck"
                }, {
                    name: "Costa Rica",
                    country: "cr"
                }, {
                    name: "Côte d’Ivoire",
                    country: "ci"
                }, {
                    name: "Croatia (Hrvatska)",
                    country: "hr"
                }, {
                    name: "Cuba",
                    country: "cu"
                }, {
                    name: "Curaçao",
                    country: "cw"
                }, {
                    name: "Cyprus (Κύπρος)",
                    country: "cy"
                }, {
                    name: "Czech Republic (Česká republika)",
                    country: "cz"
                }, {
                    name: "Denmark (Danmark)",
                    country: "dk"
                }, {
                    name: "Djibouti",
                    country: "dj"
                }, {
                    name: "Dominica",
                    country: "dm"
                }, {
                    name: "Dominican Republic (República Dominicana)",
                    country: "do"
                }, {
                    name: "Ecuador",
                    country: "ec"
                }, {
                    name: "Egypt (‫مصر‬‎)",
                    country: "eg"
                }, {
                    name: "El Salvador",
                    country: "sv"
                }, {
                    name: "Equatorial Guinea (Guinea Ecuatorial)",
                    country: "gq"
                }, {
                    name: "Eritrea",
                    country: "er"
                }, {
                    name: "Estonia (Eesti)",
                    country: "ee"
                }, {
                    name: "Ethiopia",
                    country: "et"
                }, {
                    name: "Falkland Islands (Islas Malvinas)",
                    country: "fk"
                }, {
                    name: "Faroe Islands (Føroyar)",
                    country: "fo"
                }, {
                    name: "Fiji",
                    country: "fj"
                }, {
                    name: "Finland (Suomi)",
                    country: "fi"
                }, {
                    name: "France",
                    country: "fr"
                }, {
                    name: "French Guiana (Guyane française)",
                    country: "gf"
                }, {
                    name: "French Polynesia (Polynésie française)",
                    country: "pf"
                }, {
                    name: "French Southern Territories (Terres australes françaises)",
                    country: "tf"
                }, {
                    name: "Gabon",
                    country: "ga"
                }, {
                    name: "Gambia",
                    country: "gm"
                }, {
                    name: "Georgia (საქართველო)",
                    country: "ge"
                }, {
                    name: "Germany (Deutschland)",
                    country: "de"
                }, {
                    name: "Ghana (Gaana)",
                    country: "gh"
                }, {
                    name: "Gibraltar",
                    country: "gi"
                }, {
                    name: "Greece (Ελλάδα)",
                    country: "gr"
                }, {
                    name: "Greenland (Kalaallit Nunaat)",
                    country: "gl"
                }, {
                    name: "Grenada",
                    country: "gd"
                }, {
                    name: "Guadeloupe",
                    country: "gp"
                }, {
                    name: "Guam",
                    country: "gu"
                }, {
                    name: "Guatemala",
                    country: "gt"
                }, {
                    name: "Guernsey",
                    country: "gg"
                }, {
                    name: "Guinea (Guinée)",
                    country: "gn"
                }, {
                    name: "Guinea-Bissau (Guiné Bissau)",
                    country: "gw"
                }, {
                    name: "Guyana",
                    country: "gy"
                }, {
                    name: "Haiti",
                    country: "ht"
                }, {
                    name: "Heard Island and Mcdonald Islands",
                    country: "hm"
                }, {
                    name: "Honduras",
                    country: "hn"
                }, {
                    name: "Hong Kong (香港)",
                    country: "hk"
                }, {
                    name: "Hungary (Magyarország)",
                    country: "hu"
                }, {
                    name: "Iceland (Ísland)",
                    country: "is"
                }, {
                    name: "India (भारत)",
                    country: "in"
                }, {
                    name: "Indonesia",
                    country: "id"
                }, {
                    name: "Iran (‫ایران‬‎)",
                    country: "ir"
                }, {
                    name: "Iraq (‫العراق‬‎)",
                    country: "iq"
                }, {
                    name: "Ireland",
                    country: "ie"
                }, {
                    name: "Isle of Man",
                    country: "im"
                }, {
                    name: "Israel (‫ישראל‬‎)",
                    country: "il"
                }, {
                    name: "Italy (Italia)",
                    country: "it"
                }, {
                    name: "Jamaica",
                    country: "jm"
                }, {
                    name: "Japan (日本)",
                    country: "jp"
                }, {
                    name: "Jersey",
                    country: "je"
                }, {
                    name: "Jordan (‫الأردن‬‎)",
                    country: "jo"
                }, {
                    name: "Kazakhstan (Казахстан)",
                    country: "kz"
                }, {
                    name: "Kenya",
                    country: "ke"
                }, {
                    name: "Kiribati",
                    country: "ki"
                }, {
                    name: "Kosovo (Kosovë)",
                    country: "xk"
                }, {
                    name: "Kuwait (‫الكويت‬‎)",
                    country: "kw"
                }, {
                    name: "Kyrgyzstan (Кыргызстан)",
                    country: "kg"
                }, {
                    name: "Laos (ລາວ)",
                    country: "la"
                }, {
                    name: "Latvia (Latvija)",
                    country: "lv"
                }, {
                    name: "Lebanon (‫لبنان‬‎)",
                    country: "lb"
                }, {
                    name: "Lesotho",
                    country: "ls"
                }, {
                    name: "Liberia",
                    country: "lr"
                }, {
                    name: "Libya (‫ليبيا‬‎)",
                    country: "ly"
                }, {
                    name: "Liechtenstein",
                    country: "li"
                }, {
                    name: "Lithuania (Lietuva)",
                    country: "lt"
                }, {
                    name: "Luxembourg",
                    country: "lu"
                }, {
                    name: "Macau (澳門)",
                    country: "mo"
                }, {
                    name: "Macedonia (FYROM) (Македонија)",
                    country: "mk"
                }, {
                    name: "Madagascar (Madagasikara)",
                    country: "mg"
                }, {
                    name: "Malawi",
                    country: "mw"
                }, {
                    name: "Malaysia",
                    country: "my"
                }, {
                    name: "Maldives",
                    country: "mv"
                }, {
                    name: "Mali",
                    country: "ml"
                }, {
                    name: "Malta",
                    country: "mt"
                }, {
                    name: "Marshall Islands",
                    country: "mh"
                }, {
                    name: "Martinique",
                    country: "mq"
                }, {
                    name: "Mauritania (‫موريتانيا‬‎)",
                    country: "mr"
                }, {
                    name: "Mauritius (Moris)",
                    country: "mu"
                }, {
                    name: "Mayotte",
                    country: "yt"
                }, {
                    name: "Mexico (México)",
                    country: "mx"
                }, {
                    name: "Micronesia",
                    country: "fm"
                }, {
                    name: "Moldova (Republica Moldova)",
                    country: "md"
                }, {
                    name: "Monaco",
                    country: "mc"
                }, {
                    name: "Mongolia (Монгол)",
                    country: "mn"
                }, {
                    name: "Montenegro (Crna Gora)",
                    country: "me"
                }, {
                    name: "Montserrat",
                    country: "ms"
                }, {
                    name: "Morocco (‫المغرب‬‎)",
                    country: "ma"
                }, {
                    name: "Mozambique (Moçambique)",
                    country: "mz"
                }, {
                    name: "Myanmar (Burma) (မြန်မာ)",
                    country: "mm"
                }, {
                    name: "Namibia (Namibië)",
                    country: "na"
                }, {
                    name: "Nauru",
                    country: "nr"
                }, {
                    name: "Nepal (नेपाल)",
                    country: "np"
                }, {
                    name: "Netherlands (Nederland)",
                    country: "nl"
                }, {
                    name: "New Caledonia (Nouvelle-Calédonie)",
                    country: "nc"
                }, {
                    name: "New Zealand",
                    country: "nz"
                }, {
                    name: "Nicaragua",
                    country: "ni"
                }, {
                    name: "Niger (Nijar)",
                    country: "ne"
                }, {
                    name: "Nigeria",
                    country: "ng"
                }, {
                    name: "Niue",
                    country: "nu"
                }, {
                    name: "Norfolk Island",
                    country: "nf"
                }, {
                    name: "North Korea (조선 민주주의 인민 공화국)",
                    country: "kp"
                }, {
                    name: "Northern Mariana Islands",
                    country: "mp"
                }, {
                    name: "Norway (Norge)",
                    country: "no"
                }, {
                    name: "Oman (‫عُمان‬‎)",
                    country: "om"
                }, {
                    name: "Pakistan (‫پاکستان‬‎)",
                    country: "pk"
                }, {
                    name: "Palau",
                    country: "pw"
                }, {
                    name: "Palestine (‫فلسطين‬‎)",
                    country: "ps"
                }, {
                    name: "Panama (Panamá)",
                    country: "pa"
                }, {
                    name: "Papua New Guinea",
                    country: "pg"
                }, {
                    name: "Paraguay",
                    country: "py"
                }, {
                    name: "Peru (Perú)",
                    country: "pe"
                }, {
                    name: "Philippines",
                    country: "ph"
                }, {
                    name: "Pitcairn Islands",
                    country: "pn"
                }, {
                    name: "Poland (Polska)",
                    country: "pl"
                }, {
                    name: "Portugal",
                    country: "pt"
                }, {
                    name: "Puerto Rico",
                    country: "pr"
                }, {
                    name: "Qatar (‫قطر‬‎)",
                    country: "qa"
                }, {
                    name: "Réunion (La Réunion)",
                    country: "re"
                }, {
                    name: "Romania (România)",
                    country: "ro"
                }, {
                    name: "Russia (Россия)",
                    country: "ru"
                }, {
                    name: "Rwanda",
                    country: "rw"
                }, {
                    name: "Saint Barthélemy (Saint-Barthélemy)",
                    country: "bl"
                }, {
                    name: "Saint Helena",
                    country: "sh"
                }, {
                    name: "Saint Kitts and Nevis",
                    country: "kn"
                }, {
                    name: "Saint Lucia",
                    country: "lc"
                }, {
                    name: "Saint Martin (Saint-Martin (partie française))",
                    country: "mf"
                }, {
                    name: "Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)",
                    country: "pm"
                }, {
                    name: "Saint Vincent and the Grenadines",
                    country: "vc"
                }, {
                    name: "Samoa",
                    country: "ws"
                }, {
                    name: "San Marino",
                    country: "sm"
                }, {
                    name: "São Tomé and Príncipe (São Tomé e Príncipe)",
                    country: "st"
                }, {
                    name: "Saudi Arabia (‫المملكة العربية السعودية‬‎)",
                    country: "sa"
                }, {
                    name: "Senegal (Sénégal)",
                    country: "sn"
                }, {
                    name: "Serbia (Србија)",
                    country: "rs"
                }, {
                    name: "Seychelles",
                    country: "sc"
                }, {
                    name: "Sierra Leone",
                    country: "sl"
                }, {
                    name: "Singapore",
                    country: "sg"
                }, {
                    name: "Sint Maarten",
                    country: "sx"
                }, {
                    name: "Slovakia (Slovensko)",
                    country: "sk"
                }, {
                    name: "Slovenia (Slovenija)",
                    country: "si"
                }, {
                    name: "Solomon Islands",
                    country: "sb"
                }, {
                    name: "Somalia (Soomaaliya)",
                    country: "so"
                }, {
                    name: "South Africa",
                    country: "za"
                }, {
                    name: "South Georgia & South Sandwich Islands",
                    country: "gs"
                }, {
                    name: "South Korea (대한민국)",
                    country: "kr"
                }, {
                    name: "South Sudan (‫جنوب السودان‬‎)",
                    country: "ss"
                }, {
                    name: "Spain (España)",
                    country: "es"
                }, {
                    name: "Sri Lanka (ශ්‍රී ලංකාව)",
                    country: "lk"
                }, {
                    name: "Sudan (‫السودان‬‎)",
                    country: "sd"
                }, {
                    name: "Suriname",
                    country: "sr"
                }, {
                    name: "Svalbard and Jan Mayen (Svalbard og Jan Mayen)",
                    country: "sj"
                }, {
                    name: "Swaziland",
                    country: "sz"
                }, {
                    name: "Sweden (Sverige)",
                    country: "se"
                }, {
                    name: "Switzerland (Schweiz)",
                    country: "ch"
                }, {
                    name: "Syria (‫سوريا‬‎)",
                    country: "sy"
                }, {
                    name: "Taiwan (台灣)",
                    country: "tw"
                }, {
                    name: "Tajikistan",
                    country: "tj"
                }, {
                    name: "Tanzania",
                    country: "tz"
                }, {
                    name: "Thailand (ไทย)",
                    country: "th"
                }, {
                    name: "Timor-Leste",
                    country: "tl"
                }, {
                    name: "Togo",
                    country: "tg"
                }, {
                    name: "Tokelau",
                    country: "tk"
                }, {
                    name: "Tonga",
                    country: "to"
                }, {
                    name: "Trinidad and Tobago",
                    country: "tt"
                }, {
                    name: "Tunisia (‫تونس‬‎)",
                    country: "tn"
                }, {
                    name: "Turkey (Türkiye)",
                    country: "tr"
                }, {
                    name: "Turkmenistan",
                    country: "tm"
                }, {
                    name: "Turks and Caicos Islands",
                    country: "tc"
                }, {
                    name: "Tuvalu",
                    country: "tv"
                }, {
                    name: "Uganda",
                    country: "ug"
                }, {
                    name: "Ukraine (Україна)",
                    country: "ua"
                }, {
                    name: "United Arab Emirates (‫الإمارات العربية المتحدة‬‎)",
                    country: "ae"
                }, {
                    name: "United Kingdom",
                    country: "gb"
                }, {
                    name: "United States",
                    country: "us"
                }, {
                    name: "U.S. Minor Outlying Islands",
                    country: "um"
                }, {
                    name: "U.S. Virgin Islands",
                    country: "vi"
                }, {
                    name: "Uruguay",
                    country: "uy"
                }, {
                    name: "Uzbekistan (Oʻzbekiston)",
                    country: "uz"
                }, {
                    name: "Vanuatu",
                    country: "vu"
                }, {
                    name: "Vatican City (Città del Vaticano)",
                    country: "va"
                }, {
                    name: "Venezuela",
                    country: "ve"
                }, {
                    name: "Vietnam (Việt Nam)",
                    country: "vn"
                }, {
                    name: "Wallis and Futuna",
                    country: "wf"
                }, {
                    name: "Western Sahara (‫الصحراء الغربية‬‎)",
                    country: "eh"
                }, {
                    name: "Yemen (‫اليمن‬‎)",
                    country: "ye"
                }, {
                    name: "Zambia",
                    country: "zm"
                }, {
                    name: "Zimbabwe",
                    country: "zw"
                } ]*/
            }

        },
        computed:{
            country(){
                return this.language.country || '';
            },
            country_name(){
                return this.language.name || '';
            },
            language(){
                return collect(this.languages).keyBy('value').get(this.val) || {};
            },
            ...mapState([
               'locales'
            ]),
            _languages(){
                return collect(this.languages).filter((item)=>{
                    return collect(this.locales).contains(item.value);
                }).all();
            }


        },
        methods:{
            //控制状态
            changeVal(value){
                this.val = value;
            },
            open(){
                this.$refs['view'].click();
            }
        },
        watch:{
            val(val,old) {
                if(val!=this.value){
                    this.$emit('input', val); //修改值
                    this.$emit('change',val); //修改值
                }
            },
            value(val,old){
                if(val!=this.val){
                    this.val = val;
                }
            },
        }
    }
</script>

<style scoped>
    .el-dropdown{
        color: unset;
        position: relative;
    }
    .language{
        position:relative;
        display:inline-block
    }
    .country{
        display: inline-block;
        position: relative;
        vertical-align: middle;
    }
    .flag{
        width:20px;
        height:15px;
        -webkit-box-shadow:0px 0px 1px 0px #888;
        box-shadow:0px 0px 1px 0px #888;
        background-image:url("./flags.png");
        background-repeat:no-repeat;
        background-color:#dbdbdb;
        background-position:20px 0
    }
    @media only screen and (-webkit-min-device-pixel-ratio: 2),
    only screen and (min--moz-device-pixel-ratio: 2),
    only screen and (min-device-pixel-ratio: 2),
    only screen and (min-resolution: 192dpi),
    only screen and (min-resolution: 2dppx){
        .flag{
            background-image:url("./flags@2x.png")
        }
    }
    .flag{
        width:20px
    }
/*    .flag.be{
        width:18px
    }
    .flag.ch{
        width:15px
    }
    .flag.mc{
        width:19px
    }
    .flag.ne{
        width:18px
    }
    .flag.np{
        width:13px
    }
    .flag.va{
        width:15px
    }*/
    @media only screen and (-webkit-min-device-pixel-ratio: 2),
    only screen and (min--moz-device-pixel-ratio: 2),
    only screen and (min-device-pixel-ratio: 2),
    only screen and (min-resolution: 192dpi),
    only screen and (min-resolution: 2dppx){
        .flag{
            background-size:5630px 15px
        }
    }
   /* .flag.ac{
        height:10px;
        background-position:0px 0px
    }
    .flag.ad{
        height:14px;
        background-position:-22px 0px
    }
    .flag.ae{
        height:10px;
        background-position:-44px 0px
    }
    .flag.af{
        height:14px;
        background-position:-66px 0px
    }
    .flag.ag{
        height:14px;
        background-position:-88px 0px
    }
    .flag.ai{
        height:10px;
        background-position:-110px 0px
    }
    .flag.al{
        height:15px;
        background-position:-132px 0px
    }
    .flag.am{
        height:10px;
        background-position:-154px 0px
    }
    .flag.ao{
        height:14px;
        background-position:-176px 0px
    }
    .flag.aq{
        height:14px;
        background-position:-198px 0px
    }
    .flag.ar{
        height:13px;
        background-position:-220px 0px
    }
    .flag.as{
        height:10px;
        background-position:-242px 0px
    }
    .flag.at{
        height:14px;
        background-position:-264px 0px
    }
    .flag.au{
        height:10px;
        background-position:-286px 0px
    }
    .flag.aw{
        height:14px;
        background-position:-308px 0px
    }
    .flag.ax{
        height:13px;
        background-position:-330px 0px
    }
    .flag.az{
        height:10px;
        background-position:-352px 0px
    }
    .flag.ba{
        height:10px;
        background-position:-374px 0px
    }
    .flag.bb{
        height:14px;
        background-position:-396px 0px
    }
    .flag.bd{
        height:12px;
        background-position:-418px 0px
    }
    .flag.be{
        height:15px;
        background-position:-440px 0px
    }
    .flag.bf{
        height:14px;
        background-position:-460px 0px
    }
    .flag.bg{
        height:12px;
        background-position:-482px 0px
    }
    .flag.bh{
        height:12px;
        background-position:-504px 0px
    }
    .flag.bi{
        height:12px;
        background-position:-526px 0px
    }
    .flag.bj{
        height:14px;
        background-position:-548px 0px
    }
    .flag.bl{
        height:14px;
        background-position:-570px 0px
    }
    .flag.bm{
        height:10px;
        background-position:-592px 0px
    }
    .flag.bn{
        height:10px;
        background-position:-614px 0px
    }
    .flag.bo{
        height:14px;
        background-position:-636px 0px
    }
    .flag.bq{
        height:14px;
        background-position:-658px 0px
    }
    .flag.br{
        height:14px;
        background-position:-680px 0px
    }
    .flag.bs{
        height:10px;
        background-position:-702px 0px
    }
    .flag.bt{
        height:14px;
        background-position:-724px 0px
    }
    .flag.bv{
        height:15px;
        background-position:-746px 0px
    }
    .flag.bw{
        height:14px;
        background-position:-768px 0px
    }
    .flag.by{
        height:10px;
        background-position:-790px 0px
    }
    .flag.bz{
        height:14px;
        background-position:-812px 0px
    }
    .flag.ca{
        height:10px;
        background-position:-834px 0px
    }
    .flag.cc{
        height:10px;
        background-position:-856px 0px
    }
    .flag.cd{
        height:15px;
        background-position:-878px 0px
    }
    .flag.cf{
        height:14px;
        background-position:-900px 0px
    }
    .flag.cg{
        height:14px;
        background-position:-922px 0px
    }
    .flag.ch{
        height:15px;
        background-position:-944px 0px
    }
    .flag.ci{
        height:14px;
        background-position:-961px 0px
    }
    .flag.ck{
        height:10px;
        background-position:-983px 0px
    }
    .flag.cl{
        height:14px;
        background-position:-1005px 0px
    }
    .flag.cm{
        height:14px;
        background-position:-1027px 0px
    } */
    .flag.cn{
        height:14px;
        background-position:-1049px 0px
    } /*
    .flag.co{
        height:14px;
        background-position:-1071px 0px
    }
    .flag.cp{
        height:14px;
        background-position:-1093px 0px
    }
    .flag.cr{
        height:12px;
        background-position:-1115px 0px
    }
    .flag.cu{
        height:10px;
        background-position:-1137px 0px
    }
    .flag.cv{
        height:12px;
        background-position:-1159px 0px
    }
    .flag.cw{
        height:14px;
        background-position:-1181px 0px
    }
    .flag.cx{
        height:10px;
        background-position:-1203px 0px
    }
    .flag.cy{
        height:13px;
        background-position:-1225px 0px
    }
    .flag.cz{
        height:14px;
        background-position:-1247px 0px
    }
    .flag.de{
        height:12px;
        background-position:-1269px 0px
    }
    .flag.dg{
        height:10px;
        background-position:-1291px 0px
    }
    .flag.dj{
        height:14px;
        background-position:-1313px 0px
    }
    .flag.dk{
        height:15px;
        background-position:-1335px 0px
    }
    .flag.dm{
        height:10px;
        background-position:-1357px 0px
    }
    .flag.do{
        height:13px;
        background-position:-1379px 0px
    }
    .flag.dz{
        height:14px;
        background-position:-1401px 0px
    }
    .flag.ea{
        height:14px;
        background-position:-1423px 0px
    }
    .flag.ec{
        height:14px;
        background-position:-1445px 0px
    }
    .flag.ee{
        height:13px;
        background-position:-1467px 0px
    }
    .flag.eg{
        height:14px;
        background-position:-1489px 0px
    }
    .flag.eh{
        height:10px;
        background-position:-1511px 0px
    }
    .flag.er{
        height:10px;
        background-position:-1533px 0px
    }
    */.flag.es{
        height:14px;
        background-position:-1555px 0px
    }
   /* .flag.et{
        height:10px;
        background-position:-1577px 0px
    }
    .flag.eu{
        height:14px;
        background-position:-1599px 0px
    }
    .flag.fi{
        height:12px;
        background-position:-1621px 0px
    }
    .flag.fj{
        height:10px;
        background-position:-1643px 0px
    }
    .flag.fk{
        height:10px;
        background-position:-1665px 0px
    }
    .flag.fm{
        height:11px;
        background-position:-1687px 0px
    }
    .flag.fo{
        height:15px;
        background-position:-1709px 0px
    }
    */.flag.fr{
        height:14px;
        background-position:-1731px 0px
    }
    .flag.ga{
        height:15px;
        background-position:-1753px 0px
    }
    .flag.gb{
        height:10px;
        background-position:-1775px 0px
    }/*
    .flag.gd{
        height:12px;
        background-position:-1797px 0px
    }
    .flag.ge{
        height:14px;
        background-position:-1819px 0px
    }
    .flag.gf{
        height:14px;
        background-position:-1841px 0px
    }
    .flag.gg{
        height:14px;
        background-position:-1863px 0px
    }
    .flag.gh{
        height:14px;
        background-position:-1885px 0px
    }
    .flag.gi{
        height:10px;
        background-position:-1907px 0px
    }
    .flag.gl{
        height:14px;
        background-position:-1929px 0px
    }
    .flag.gm{
        height:14px;
        background-position:-1951px 0px
    }
    .flag.gn{
        height:14px;
        background-position:-1973px 0px
    }
    .flag.gp{
        height:14px;
        background-position:-1995px 0px
    }
    .flag.gq{
        height:14px;
        background-position:-2017px 0px
    }
    .flag.gr{
        height:14px;
        background-position:-2039px 0px
    }
    .flag.gs{
        height:10px;
        background-position:-2061px 0px
    }
    .flag.gt{
        height:13px;
        background-position:-2083px 0px
    }
    .flag.gu{
        height:11px;
        background-position:-2105px 0px
    }
    .flag.gw{
        height:10px;
        background-position:-2127px 0px
    }
    .flag.gy{
        height:12px;
        background-position:-2149px 0px
    }*/
    .flag.hk{
        height:14px;
        background-position:-2171px 0px
    }/*
    .flag.hm{
        height:10px;
        background-position:-2193px 0px
    }
    .flag.hn{
        height:10px;
        background-position:-2215px 0px
    }
    .flag.hr{
        height:10px;
        background-position:-2237px 0px
    }
    .flag.ht{
        height:12px;
        background-position:-2259px 0px
    }
    .flag.hu{
        height:10px;
        background-position:-2281px 0px
    }
    .flag.ic{
        height:14px;
        background-position:-2303px 0px
    }
    .flag.id{
        height:14px;
        background-position:-2325px 0px
    }
    .flag.ie{
        height:10px;
        background-position:-2347px 0px
    }
    .flag.il{
        height:15px;
        background-position:-2369px 0px
    }
    .flag.im{
        height:10px;
        background-position:-2391px 0px
    }
    .flag.in{
        height:14px;
        background-position:-2413px 0px
    }
    .flag.io{
        height:10px;
        background-position:-2435px 0px
    }
    .flag.iq{
        height:14px;
        background-position:-2457px 0px
    }
    .flag.ir{
        height:12px;
        background-position:-2479px 0px
    }
    .flag.is{
        height:15px;
        background-position:-2501px 0px
    }
    .flag.it{
        height:14px;
        background-position:-2523px 0px
    }
    .flag.je{
        height:12px;
        background-position:-2545px 0px
    }
    .flag.jm{
        height:10px;
        background-position:-2567px 0px
    }
    .flag.jo{
        height:10px;
        background-position:-2589px 0px
    }*/
    .flag.jp{
        height:14px;
        background-position:-2611px 0px
    }
    /*.flag.ke{
        height:14px;
        background-position:-2633px 0px
    }
    .flag.kg{
        height:12px;
        background-position:-2655px 0px
    }
    .flag.kh{
        height:13px;
        background-position:-2677px 0px
    }
    .flag.ki{
        height:10px;
        background-position:-2699px 0px
    }
    .flag.km{
        height:12px;
        background-position:-2721px 0px
    }
    .flag.kn{
        height:14px;
        background-position:-2743px 0px
    }
    .flag.kp{
        height:10px;
        background-position:-2765px 0px
    }
    */.flag.kr{
        height:14px;
        background-position:-2787px 0px
    }
    /*.flag.kw{
        height:10px;
        background-position:-2809px 0px
    }
    .flag.ky{
        height:10px;
        background-position:-2831px 0px
    }
    .flag.kz{
        height:10px;
        background-position:-2853px 0px
    }
    .flag.la{
        height:14px;
        background-position:-2875px 0px
    }
    .flag.lb{
        height:14px;
        background-position:-2897px 0px
    }
    .flag.lc{
        height:10px;
        background-position:-2919px 0px
    }
    .flag.li{
        height:12px;
        background-position:-2941px 0px
    }
    .flag.lk{
        height:10px;
        background-position:-2963px 0px
    }
    .flag.lr{
        height:11px;
        background-position:-2985px 0px
    }
    .flag.ls{
        height:14px;
        background-position:-3007px 0px
    }
    .flag.lt{
        height:12px;
        background-position:-3029px 0px
    }
    .flag.lu{
        height:12px;
        background-position:-3051px 0px
    }
    .flag.lv{
        height:10px;
        background-position:-3073px 0px
    }
    .flag.ly{
        height:10px;
        background-position:-3095px 0px
    }
    .flag.ma{
        height:14px;
        background-position:-3117px 0px
    }
    .flag.mc{
        height:15px;
        background-position:-3139px 0px
    }
    .flag.md{
        height:10px;
        background-position:-3160px 0px
    }
    .flag.me{
        height:10px;
        background-position:-3182px 0px
    }
    .flag.mf{
        height:14px;
        background-position:-3204px 0px
    }
    .flag.mg{
        height:14px;
        background-position:-3226px 0px
    }
    .flag.mh{
        height:11px;
        background-position:-3248px 0px
    }
    .flag.mk{
        height:10px;
        background-position:-3270px 0px
    }
    .flag.ml{
        height:14px;
        background-position:-3292px 0px
    }
    .flag.mm{
        height:14px;
        background-position:-3314px 0px
    }
    .flag.mn{
        height:10px;
        background-position:-3336px 0px
    }
    .flag.mo{
        height:14px;
        background-position:-3358px 0px
    }
    .flag.mp{
        height:10px;
        background-position:-3380px 0px
    }
    .flag.mq{
        height:14px;
        background-position:-3402px 0px
    }
    .flag.mr{
        height:14px;
        background-position:-3424px 0px
    }
    .flag.ms{
        height:10px;
        background-position:-3446px 0px
    }
    .flag.mt{
        height:14px;
        background-position:-3468px 0px
    }
    .flag.mu{
        height:14px;
        background-position:-3490px 0px
    }
    .flag.mv{
        height:14px;
        background-position:-3512px 0px
    }
    .flag.mw{
        height:14px;
        background-position:-3534px 0px
    }
    .flag.mx{
        height:12px;
        background-position:-3556px 0px
    }
    .flag.my{
        height:10px;
        background-position:-3578px 0px
    }
    .flag.mz{
        height:14px;
        background-position:-3600px 0px
    }
    .flag.na{
        height:14px;
        background-position:-3622px 0px
    }
    .flag.nc{
        height:10px;
        background-position:-3644px 0px
    }
    .flag.ne{
        height:15px;
        background-position:-3666px 0px
    }
    .flag.nf{
        height:10px;
        background-position:-3686px 0px
    }
    .flag.ng{
        height:10px;
        background-position:-3708px 0px
    }
    .flag.ni{
        height:12px;
        background-position:-3730px 0px
    }
    .flag.nl{
        height:14px;
        background-position:-3752px 0px
    }
    .flag.no{
        height:15px;
        background-position:-3774px 0px
    }
    .flag.np{
        height:15px;
        background-position:-3796px 0px;
        background-color:transparent
    }
    .flag.nr{
        height:10px;
        background-position:-3811px 0px
    }
    .flag.nu{
        height:10px;
        background-position:-3833px 0px
    }
    .flag.nz{
        height:10px;
        background-position:-3855px 0px
    }
    .flag.om{
        height:10px;
        background-position:-3877px 0px
    }
    .flag.pa{
        height:14px;
        background-position:-3899px 0px
    }
    .flag.pe{
        height:14px;
        background-position:-3921px 0px
    }
    .flag.pf{
        height:14px;
        background-position:-3943px 0px
    }
    .flag.pg{
        height:15px;
        background-position:-3965px 0px
    }
    .flag.ph{
        height:10px;
        background-position:-3987px 0px
    }
    .flag.pk{
        height:14px;
        background-position:-4009px 0px
    }
    .flag.pl{
        height:13px;
        background-position:-4031px 0px
    }
    .flag.pm{
        height:14px;
        background-position:-4053px 0px
    }
    .flag.pn{
        height:10px;
        background-position:-4075px 0px
    }
    .flag.pr{
        height:14px;
        background-position:-4097px 0px
    }
    .flag.ps{
        height:10px;
        background-position:-4119px 0px
    }
    */.flag.pt{
        height:14px;
        background-position:-4141px 0px
    }
    /*.flag.pw{
        height:13px;
        background-position:-4163px 0px
    }
    .flag.py{
        height:11px;
        background-position:-4185px 0px
    }
    .flag.qa{
        height:8px;
        background-position:-4207px 0px
    }
    .flag.re{
        height:14px;
        background-position:-4229px 0px
    }
    .flag.ro{
        height:14px;
        background-position:-4251px 0px
    }
    .flag.rs{
        height:14px;
        background-position:-4273px 0px
    }
    */.flag.ru{
        height:14px;
        background-position:-4295px 0px
    }
    /*.flag.rw{
        height:14px;
        background-position:-4317px 0px
    }
    .flag.sa{
        height:14px;
        background-position:-4339px 0px
    }
    .flag.sb{
        height:10px;
        background-position:-4361px 0px
    }
    .flag.sc{
        height:10px;
        background-position:-4383px 0px
    }
    .flag.sd{
        height:10px;
        background-position:-4405px 0px
    }
    .flag.se{
        height:13px;
        background-position:-4427px 0px
    }
    .flag.sg{
        height:14px;
        background-position:-4449px 0px
    }
    .flag.sh{
        height:10px;
        background-position:-4471px 0px
    }
    .flag.si{
        height:10px;
        background-position:-4493px 0px
    }
    .flag.sj{
        height:15px;
        background-position:-4515px 0px
    }
    .flag.sk{
        height:14px;
        background-position:-4537px 0px
    }
    .flag.sl{
        height:14px;
        background-position:-4559px 0px
    }
    .flag.sm{
        height:15px;
        background-position:-4581px 0px
    }
    .flag.sn{
        height:14px;
        background-position:-4603px 0px
    }
    .flag.so{
        height:14px;
        background-position:-4625px 0px
    }
    .flag.sr{
        height:14px;
        background-position:-4647px 0px
    }
    .flag.ss{
        height:10px;
        background-position:-4669px 0px
    }
    .flag.st{
        height:10px;
        background-position:-4691px 0px
    }
    .flag.sv{
        height:12px;
        background-position:-4713px 0px
    }
    .flag.sx{
        height:14px;
        background-position:-4735px 0px
    }
    .flag.sy{
        height:14px;
        background-position:-4757px 0px
    }
    .flag.sz{
        height:14px;
        background-position:-4779px 0px
    }
    .flag.ta{
        height:10px;
        background-position:-4801px 0px
    }
    .flag.tc{
        height:10px;
        background-position:-4823px 0px
    }
    .flag.td{
        height:14px;
        background-position:-4845px 0px
    }
    .flag.tf{
        height:14px;
        background-position:-4867px 0px
    }
    .flag.tg{
        height:13px;
        background-position:-4889px 0px
    }
    .flag.th{
        height:14px;
        background-position:-4911px 0px
    }
    .flag.tj{
        height:10px;
        background-position:-4933px 0px
    }
    .flag.tk{
        height:10px;
        background-position:-4955px 0px
    }
    .flag.tl{
        height:10px;
        background-position:-4977px 0px
    }
    .flag.tm{
        height:14px;
        background-position:-4999px 0px
    }
    .flag.tn{
        height:14px;
        background-position:-5021px 0px
    }
    .flag.to{
        height:10px;
        background-position:-5043px 0px
    }
    .flag.tr{
        height:14px;
        background-position:-5065px 0px
    }
    .flag.tt{
        height:12px;
        background-position:-5087px 0px
    }
    .flag.tv{
        height:10px;
        background-position:-5109px 0px
    }*/
    .flag.tw{
        height:14px;
        background-position:-5131px 0px
    }/*
    .flag.tz{
        height:14px;
        background-position:-5153px 0px
    }
    .flag.ua{
        height:14px;
        background-position:-5175px 0px
    }
    .flag.ug{
        height:14px;
        background-position:-5197px 0px
    }
    .flag.um{
        height:11px;
        background-position:-5219px 0px
    }
    .flag.us{
        height:11px;
        background-position:-5241px 0px
    }
    .flag.uy{
        height:14px;
        background-position:-5263px 0px
    }
    .flag.uz{
        height:10px;
        background-position:-5285px 0px
    }
    .flag.va{
        height:15px;
        background-position:-5307px 0px
    }
    .flag.vc{
        height:14px;
        background-position:-5324px 0px
    }
    .flag.ve{
        height:14px;
        background-position:-5346px 0px
    }
    .flag.vg{
        height:10px;
        background-position:-5368px 0px
    }
    .flag.vi{
        height:14px;
        background-position:-5390px 0px
    }
    .flag.vn{
        height:14px;
        background-position:-5412px 0px
    }
    .flag.vu{
        height:12px;
        background-position:-5434px 0px
    }
    .flag.wf{
        height:14px;
        background-position:-5456px 0px
    }*/
</style>
