<template>
    <div class="language">
        <el-dropdown @command="changeVal" trigger="click">
            <div ref="view">
                <span v-if="isLanguage">
                    <i class="fa fa-globe"></i>
                </span>
                <span v-else>
                    <div class="country" v-if="val">
                        <div class="flag" :class="country_or_region"></div>
                    </div>
                    <i class="fa fa-globe" v-else></i>
                </span>
                <span class="country-name">{{country_or_region_name || $t('Language')}}</span>
            </div>
            <el-dropdown-menu slot="dropdown">
                <el-dropdown-item :command="item.value" v-for="(item,index) in _languages" v-bind:key="index">
                    <span v-if="isLanguage">
                          <span class="country-name">{{item.language}}</span>
                    </span>
                    <span v-else>
                        <div class="country">
                            <div class="flag" :class="item.country_or_region"></div>
                        </div>
                        <span class="country-name">{{item.name}} {{item.en_name}}</span>
                    </span>
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
            isLanguage:{
                default() {
                    return true;
                }
            }
        },
        data: function () {
            return {
                val:this.value,
                languages:[
                    {
                        value:"zh-CN",
                        name:"中国",
                        en_name:"China",
                        country_or_region:"cn",
                        language:'中文 (简体)'
                    },
                    {
                        value:"zh-TW",
                        name: "中國(台灣)",
                        en_name:"China (Taiwan)",
                        country_or_region: "tw",
                        language:'中文 (繁體)'
                    },
                    {
                        value:"zh-HK",
                        name: "中國(香港)",
                        en_name:"China (Hong Kong)",
                        country_or_region: "hk",
                        language:'中文 (繁體)',
                    },
                    {
                        value:"en",
                        name:"English",
                        en_name:"Britain",
                        country_or_region:"gb",
                        language:'English'
                    },
                    {
                        value:"ja",
                        name: "日本",
                        country_or_region: "jp",
                        en_name:"Japan",
                        language:'日本語',
                    },
                    {
                        value:"ko",
                        name: "대한민국",
                        country_or_region: "kr",
                        en_name:"South Korea",
                        language:'한국어',
                    },
                    {
                        value:"fr",
                        name: "La France",
                        en_name: "France",
                        country_or_region: "fr",
                        language:'Français',
                    },
                    {
                        value:"ru",
                        name: "Россия",
                        en_name: "Russia",
                        country_or_region: "ru",
                        language:'Русский',
                    },
                    {
                        value:"es",
                        name: "España",
                        en_name: "Spain",
                        country_or_region: "es",
                        language:'Español',
                    },
                    {
                        value:"pt",
                        name: "Portugal",
                        en_name: "Portugal",
                        country_or_region: "pt",
                        language:'Português',
                    },
                    {
                        value:"per",
                        name: "فارسی",
                        en_name: "Persian",
                        country_or_region: "per",
                        language:'فارسی',
                    },
                    {
                        value:"de",
                        name: "Deutschland",
                        en_name: "German",
                        country_or_region: "de",
                        language:'Deutsch',
                    },
                    {
                        value:"it",
                        name: "Italia",
                        en_name: "Italy",
                        country_or_region: "it",
                        language:'Italiano',
                    }

                ],
                /*   countries_reference:[
                       {
                       name: "Afghanistan (‫افغانستان‬‎)",
                       country_or_region: "af"
                   }, {
                       name: "Åland Islands (Åland)",
                       country_or_region: "ax"
                   }, {
                       name: "Albania (Shqipëri)",
                       country_or_region: "al"
                   }, {
                       name: "Algeria (‫الجزائر‬‎)",
                       country_or_region: "dz"
                   }, {
                       name: "American Samoa",
                       country_or_region: "as"
                   }, {
                       name: "Andorra",
                       country_or_region: "ad"
                   }, {
                       name: "Angola",
                       country_or_region: "ao"
                   }, {
                       name: "Anguilla",
                       country_or_region: "ai"
                   }, {
                       name: "Antarctica",
                       country_or_region: "aq"
                   }, {
                       name: "Antigua and Barbuda",
                       country_or_region: "ag"
                   }, {
                       name: "Argentina",
                       country_or_region: "ar"
                   }, {
                       name: "Armenia (Հայաստան)",
                       country_or_region: "am"
                   }, {
                       name: "Aruba",
                       country_or_region: "aw"
                   }, {
                       name: "Australia",
                       country_or_region: "au"
                   }, {
                       name: "Austria (Österreich)",
                       country_or_region: "at"
                   }, {
                       name: "Azerbaijan (Azərbaycan)",
                       country_or_region: "az"
                   }, {
                       name: "Bahamas",
                       country_or_region: "bs"
                   }, {
                       name: "Bahrain (‫البحرين‬‎)",
                       country_or_region: "bh"
                   }, {
                       name: "Bangladesh (বাংলাদেশ)",
                       country_or_region: "bd"
                   }, {
                       name: "Barbados",
                       country_or_region: "bb"
                   }, {
                       name: "Belarus (Беларусь)",
                       country_or_region: "by"
                   }, {
                       name: "Belgium (België)",
                       country_or_region: "be"
                   }, {
                       name: "Belize",
                       country_or_region: "bz"
                   }, {
                       name: "Benin (Bénin)",
                       country_or_region: "bj"
                   }, {
                       name: "Bermuda",
                       country_or_region: "bm"
                   }, {
                       name: "Bhutan (འབྲུག)",
                       country_or_region: "bt"
                   }, {
                       name: "Bolivia",
                       country_or_region: "bo"
                   }, {
                       name: "Bosnia and Herzegovina (Босна и Херцеговина)",
                       country_or_region: "ba"
                   }, {
                       name: "Botswana",
                       country_or_region: "bw"
                   }, {
                       name: "Bouvet Island (Bouvetøya)",
                       country_or_region: "bv"
                   }, {
                       name: "Brazil (Brasil)",
                       country_or_region: "br"
                   }, {
                       name: "British Indian Ocean Territory",
                       country_or_region: "io"
                   }, {
                       name: "British Virgin Islands",
                       country_or_region: "vg"
                   }, {
                       name: "Brunei",
                       country_or_region: "bn"
                   }, {
                       name: "Bulgaria (България)",
                       country_or_region: "bg"
                   }, {
                       name: "Burkina Faso",
                       country_or_region: "bf"
                   }, {
                       name: "Burundi (Uburundi)",
                       country_or_region: "bi"
                   }, {
                       name: "Cambodia (កម្ពុជា)",
                       country_or_region: "kh"
                   }, {
                       name: "Cameroon (Cameroun)",
                       country_or_region: "cm"
                   }, {
                       name: "Canada",
                       country_or_region: "ca"
                   }, {
                       name: "Cape Verde (Kabu Verdi)",
                       country_or_region: "cv"
                   }, {
                       name: "Caribbean Netherlands",
                       country_or_region: "bq"
                   }, {
                       name: "Cayman Islands",
                       country_or_region: "ky"
                   }, {
                       name: "Central African Republic (République Centrafricaine)",
                       country_or_region: "cf"
                   }, {
                       name: "Chad (Tchad)",
                       country_or_region: "td"
                   }, {
                       name: "Chile",
                       country_or_region: "cl"
                   }, {
                       name: "China (中国)",
                       country_or_region: "cn"
                   }, {
                       name: "Christmas Island",
                       country_or_region: "cx"
                   }, {
                       name: "Cocos (Keeling) Islands (Kepulauan Cocos (Keeling))",
                       country_or_region: "cc"
                   }, {
                       name: "Colombia",
                       country_or_region: "co"
                   }, {
                       name: "Comoros (‫جزر القمر‬‎)",
                       country_or_region: "km"
                   }, {
                       name: "Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)",
                       country_or_region: "cd"
                   }, {
                       name: "Congo (Republic) (Congo-Brazzaville)",
                       country_or_region: "cg"
                   }, {
                       name: "Cook Islands",
                       country_or_region: "ck"
                   }, {
                       name: "Costa Rica",
                       country_or_region: "cr"
                   }, {
                       name: "Côte d’Ivoire",
                       country_or_region: "ci"
                   }, {
                       name: "Croatia (Hrvatska)",
                       country_or_region: "hr"
                   }, {
                       name: "Cuba",
                       country_or_region: "cu"
                   }, {
                       name: "Curaçao",
                       country_or_region: "cw"
                   }, {
                       name: "Cyprus (Κύπρος)",
                       country_or_region: "cy"
                   }, {
                       name: "Czech Republic (Česká republika)",
                       country_or_region: "cz"
                   }, {
                       name: "Denmark (Danmark)",
                       country_or_region: "dk"
                   }, {
                       name: "Djibouti",
                       country_or_region: "dj"
                   }, {
                       name: "Dominica",
                       country_or_region: "dm"
                   }, {
                       name: "Dominican Republic (República Dominicana)",
                       country_or_region: "do"
                   }, {
                       name: "Ecuador",
                       country_or_region: "ec"
                   }, {
                       name: "Egypt (‫مصر‬‎)",
                       country_or_region: "eg"
                   }, {
                       name: "El Salvador",
                       country_or_region: "sv"
                   }, {
                       name: "Equatorial Guinea (Guinea Ecuatorial)",
                       country_or_region: "gq"
                   }, {
                       name: "Eritrea",
                       country_or_region: "er"
                   }, {
                       name: "Estonia (Eesti)",
                       country_or_region: "ee"
                   }, {
                       name: "Ethiopia",
                       country_or_region: "et"
                   }, {
                       name: "Falkland Islands (Islas Malvinas)",
                       country_or_region: "fk"
                   }, {
                       name: "Faroe Islands (Føroyar)",
                       country_or_region: "fo"
                   }, {
                       name: "Fiji",
                       country_or_region: "fj"
                   }, {
                       name: "Finland (Suomi)",
                       country_or_region: "fi"
                   }, {
                       name: "France",
                       country_or_region: "fr"
                   }, {
                       name: "French Guiana (Guyane française)",
                       country_or_region: "gf"
                   }, {
                       name: "French Polynesia (Polynésie française)",
                       country_or_region: "pf"
                   }, {
                       name: "French Southern Territories (Terres australes françaises)",
                       country_or_region: "tf"
                   }, {
                       name: "Gabon",
                       country_or_region: "ga"
                   }, {
                       name: "Gambia",
                       country_or_region: "gm"
                   }, {
                       name: "Georgia (საქართველო)",
                       country_or_region: "ge"
                   }, {
                       name: "Germany (Deutschland)",
                       country_or_region: "de"
                   }, {
                       name: "Ghana (Gaana)",
                       country_or_region: "gh"
                   }, {
                       name: "Gibraltar",
                       country_or_region: "gi"
                   }, {
                       name: "Greece (Ελλάδα)",
                       country_or_region: "gr"
                   }, {
                       name: "Greenland (Kalaallit Nunaat)",
                       country_or_region: "gl"
                   }, {
                       name: "Grenada",
                       country_or_region: "gd"
                   }, {
                       name: "Guadeloupe",
                       country_or_region: "gp"
                   }, {
                       name: "Guam",
                       country_or_region: "gu"
                   }, {
                       name: "Guatemala",
                       country_or_region: "gt"
                   }, {
                       name: "Guernsey",
                       country_or_region: "gg"
                   }, {
                       name: "Guinea (Guinée)",
                       country_or_region: "gn"
                   }, {
                       name: "Guinea-Bissau (Guiné Bissau)",
                       country_or_region: "gw"
                   }, {
                       name: "Guyana",
                       country_or_region: "gy"
                   }, {
                       name: "Haiti",
                       country_or_region: "ht"
                   }, {
                       name: "Heard Island and Mcdonald Islands",
                       country_or_region: "hm"
                   }, {
                       name: "Honduras",
                       country_or_region: "hn"
                   }, {
                       name: "Hong Kong (香港)",
                       country_or_region: "hk"
                   }, {
                       name: "Hungary (Magyarország)",
                       country_or_region: "hu"
                   }, {
                       name: "Iceland (Ísland)",
                       country_or_region: "is"
                   }, {
                       name: "India (भारत)",
                       country_or_region: "in"
                   }, {
                       name: "Indonesia",
                       country_or_region: "id"
                   }, {
                       name: "Iran (‫ایران‬‎)",
                       country_or_region: "ir"
                   }, {
                       name: "Iraq (‫العراق‬‎)",
                       country_or_region: "iq"
                   }, {
                       name: "Ireland",
                       country_or_region: "ie"
                   }, {
                       name: "Isle of Man",
                       country_or_region: "im"
                   }, {
                       name: "Israel (‫ישראל‬‎)",
                       country_or_region: "il"
                   }, {
                       name: "Italy (Italia)",
                       country_or_region: "it"
                   }, {
                       name: "Jamaica",
                       country_or_region: "jm"
                   }, {
                       name: "Japan (日本)",
                       country_or_region: "jp"
                   }, {
                       name: "Jersey",
                       country_or_region: "je"
                   }, {
                       name: "Jordan (‫الأردن‬‎)",
                       country_or_region: "jo"
                   }, {
                       name: "Kazakhstan (Казахстан)",
                       country_or_region: "kz"
                   }, {
                       name: "Kenya",
                       country_or_region: "ke"
                   }, {
                       name: "Kiribati",
                       country_or_region: "ki"
                   }, {
                       name: "Kosovo (Kosovë)",
                       country_or_region: "xk"
                   }, {
                       name: "Kuwait (‫الكويت‬‎)",
                       country_or_region: "kw"
                   }, {
                       name: "Kyrgyzstan (Кыргызстан)",
                       country_or_region: "kg"
                   }, {
                       name: "Laos (ລາວ)",
                       country_or_region: "la"
                   }, {
                       name: "Latvia (Latvija)",
                       country_or_region: "lv"
                   }, {
                       name: "Lebanon (‫لبنان‬‎)",
                       country_or_region: "lb"
                   }, {
                       name: "Lesotho",
                       country_or_region: "ls"
                   }, {
                       name: "Liberia",
                       country_or_region: "lr"
                   }, {
                       name: "Libya (‫ليبيا‬‎)",
                       country_or_region: "ly"
                   }, {
                       name: "Liechtenstein",
                       country_or_region: "li"
                   }, {
                       name: "Lithuania (Lietuva)",
                       country_or_region: "lt"
                   }, {
                       name: "Luxembourg",
                       country_or_region: "lu"
                   }, {
                       name: "Macau (澳門)",
                       country_or_region: "mo"
                   }, {
                       name: "Macedonia (FYROM) (Македонија)",
                       country_or_region: "mk"
                   }, {
                       name: "Madagascar (Madagasikara)",
                       country_or_region: "mg"
                   }, {
                       name: "Malawi",
                       country_or_region: "mw"
                   }, {
                       name: "Malaysia",
                       country_or_region: "my"
                   }, {
                       name: "Maldives",
                       country_or_region: "mv"
                   }, {
                       name: "Mali",
                       country_or_region: "ml"
                   }, {
                       name: "Malta",
                       country_or_region: "mt"
                   }, {
                       name: "Marshall Islands",
                       country_or_region: "mh"
                   }, {
                       name: "Martinique",
                       country_or_region: "mq"
                   }, {
                       name: "Mauritania (‫موريتانيا‬‎)",
                       country_or_region: "mr"
                   }, {
                       name: "Mauritius (Moris)",
                       country_or_region: "mu"
                   }, {
                       name: "Mayotte",
                       country_or_region: "yt"
                   }, {
                       name: "Mexico (México)",
                       country_or_region: "mx"
                   }, {
                       name: "Micronesia",
                       country_or_region: "fm"
                   }, {
                       name: "Moldova (Republica Moldova)",
                       country_or_region: "md"
                   }, {
                       name: "Monaco",
                       country_or_region: "mc"
                   }, {
                       name: "Mongolia (Монгол)",
                       country_or_region: "mn"
                   }, {
                       name: "Montenegro (Crna Gora)",
                       country_or_region: "me"
                   }, {
                       name: "Montserrat",
                       country_or_region: "ms"
                   }, {
                       name: "Morocco (‫المغرب‬‎)",
                       country_or_region: "ma"
                   }, {
                       name: "Mozambique (Moçambique)",
                       country_or_region: "mz"
                   }, {
                       name: "Myanmar (Burma) (မြန်မာ)",
                       country_or_region: "mm"
                   }, {
                       name: "Namibia (Namibië)",
                       country_or_region: "na"
                   }, {
                       name: "Nauru",
                       country_or_region: "nr"
                   }, {
                       name: "Nepal (नेपाल)",
                       country_or_region: "np"
                   }, {
                       name: "Netherlands (Nederland)",
                       country_or_region: "nl"
                   }, {
                       name: "New Caledonia (Nouvelle-Calédonie)",
                       country_or_region: "nc"
                   }, {
                       name: "New Zealand",
                       country_or_region: "nz"
                   }, {
                       name: "Nicaragua",
                       country_or_region: "ni"
                   }, {
                       name: "Niger (Nijar)",
                       country_or_region: "ne"
                   }, {
                       name: "Nigeria",
                       country_or_region: "ng"
                   }, {
                       name: "Niue",
                       country_or_region: "nu"
                   }, {
                       name: "Norfolk Island",
                       country_or_region: "nf"
                   }, {
                       name: "North Korea (조선 민주주의 인민 공화국)",
                       country_or_region: "kp"
                   }, {
                       name: "Northern Mariana Islands",
                       country_or_region: "mp"
                   }, {
                       name: "Norway (Norge)",
                       country_or_region: "no"
                   }, {
                       name: "Oman (‫عُمان‬‎)",
                       country_or_region: "om"
                   }, {
                       name: "Pakistan (‫پاکستان‬‎)",
                       country_or_region: "pk"
                   }, {
                       name: "Palau",
                       country_or_region: "pw"
                   }, {
                       name: "Palestine (‫فلسطين‬‎)",
                       country_or_region: "ps"
                   }, {
                       name: "Panama (Panamá)",
                       country_or_region: "pa"
                   }, {
                       name: "Papua New Guinea",
                       country_or_region: "pg"
                   }, {
                       name: "Paraguay",
                       country_or_region: "py"
                   }, {
                       name: "Peru (Perú)",
                       country_or_region: "pe"
                   }, {
                       name: "Philippines",
                       country_or_region: "ph"
                   }, {
                       name: "Pitcairn Islands",
                       country_or_region: "pn"
                   }, {
                       name: "Poland (Polska)",
                       country_or_region: "pl"
                   }, {
                       name: "Portugal",
                       country_or_region: "pt"
                   }, {
                       name: "Puerto Rico",
                       country_or_region: "pr"
                   }, {
                       name: "Qatar (‫قطر‬‎)",
                       country_or_region: "qa"
                   }, {
                       name: "Réunion (La Réunion)",
                       country_or_region: "re"
                   }, {
                       name: "Romania (România)",
                       country_or_region: "ro"
                   }, {
                       name: "Russia (Россия)",
                       country_or_region: "ru"
                   }, {
                       name: "Rwanda",
                       country_or_region: "rw"
                   }, {
                       name: "Saint Barthélemy (Saint-Barthélemy)",
                       country_or_region: "bl"
                   }, {
                       name: "Saint Helena",
                       country_or_region: "sh"
                   }, {
                       name: "Saint Kitts and Nevis",
                       country_or_region: "kn"
                   }, {
                       name: "Saint Lucia",
                       country_or_region: "lc"
                   }, {
                       name: "Saint Martin (Saint-Martin (partie française))",
                       country_or_region: "mf"
                   }, {
                       name: "Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)",
                       country_or_region: "pm"
                   }, {
                       name: "Saint Vincent and the Grenadines",
                       country_or_region: "vc"
                   }, {
                       name: "Samoa",
                       country_or_region: "ws"
                   }, {
                       name: "San Marino",
                       country_or_region: "sm"
                   }, {
                       name: "São Tomé and Príncipe (São Tomé e Príncipe)",
                       country_or_region: "st"
                   }, {
                       name: "Saudi Arabia (‫المملكة العربية السعودية‬‎)",
                       country_or_region: "sa"
                   }, {
                       name: "Senegal (Sénégal)",
                       country_or_region: "sn"
                   }, {
                       name: "Serbia (Србија)",
                       country_or_region: "rs"
                   }, {
                       name: "Seychelles",
                       country_or_region: "sc"
                   }, {
                       name: "Sierra Leone",
                       country_or_region: "sl"
                   }, {
                       name: "Singapore",
                       country_or_region: "sg"
                   }, {
                       name: "Sint Maarten",
                       country_or_region: "sx"
                   }, {
                       name: "Slovakia (Slovensko)",
                       country_or_region: "sk"
                   }, {
                       name: "Slovenia (Slovenija)",
                       country_or_region: "si"
                   }, {
                       name: "Solomon Islands",
                       country_or_region: "sb"
                   }, {
                       name: "Somalia (Soomaaliya)",
                       country_or_region: "so"
                   }, {
                       name: "South Africa",
                       country_or_region: "za"
                   }, {
                       name: "South Georgia & South Sandwich Islands",
                       country_or_region: "gs"
                   }, {
                       name: "South Korea (대한민국)",
                       country_or_region: "kr"
                   }, {
                       name: "South Sudan (‫جنوب السودان‬‎)",
                       country_or_region: "ss"
                   }, {
                       name: "Spain (España)",
                       country_or_region: "es"
                   }, {
                       name: "Sri Lanka (ශ්‍රී ලංකාව)",
                       country_or_region: "lk"
                   }, {
                       name: "Sudan (‫السودان‬‎)",
                       country_or_region: "sd"
                   }, {
                       name: "Suriname",
                       country_or_region: "sr"
                   }, {
                       name: "Svalbard and Jan Mayen (Svalbard og Jan Mayen)",
                       country_or_region: "sj"
                   }, {
                       name: "Swaziland",
                       country_or_region: "sz"
                   }, {
                       name: "Sweden (Sverige)",
                       country_or_region: "se"
                   }, {
                       name: "Switzerland (Schweiz)",
                       country_or_region: "ch"
                   }, {
                       name: "Syria (‫سوريا‬‎)",
                       country_or_region: "sy"
                   }, {
                       name: "Taiwan (台灣)",
                       country_or_region: "tw"
                   }, {
                       name: "Tajikistan",
                       country_or_region: "tj"
                   }, {
                       name: "Tanzania",
                       country_or_region: "tz"
                   }, {
                       name: "Thailand (ไทย)",
                       country_or_region: "th"
                   }, {
                       name: "Timor-Leste",
                       country_or_region: "tl"
                   }, {
                       name: "Togo",
                       country_or_region: "tg"
                   }, {
                       name: "Tokelau",
                       country_or_region: "tk"
                   }, {
                       name: "Tonga",
                       country_or_region: "to"
                   }, {
                       name: "Trinidad and Tobago",
                       country_or_region: "tt"
                   }, {
                       name: "Tunisia (‫تونس‬‎)",
                       country_or_region: "tn"
                   }, {
                       name: "Turkey (Türkiye)",
                       country_or_region: "tr"
                   }, {
                       name: "Turkmenistan",
                       country_or_region: "tm"
                   }, {
                       name: "Turks and Caicos Islands",
                       country_or_region: "tc"
                   }, {
                       name: "Tuvalu",
                       country_or_region: "tv"
                   }, {
                       name: "Uganda",
                       country_or_region: "ug"
                   }, {
                       name: "Ukraine (Україна)",
                       country_or_region: "ua"
                   }, {
                       name: "United Arab Emirates (‫الإمارات العربية المتحدة‬‎)",
                       country_or_region: "ae"
                   }, {
                       name: "United Kingdom",
                       country_or_region: "gb"
                   }, {
                       name: "United States",
                       country_or_region: "us"
                   }, {
                       name: "U.S. Minor Outlying Islands",
                       country_or_region: "um"
                   }, {
                       name: "U.S. Virgin Islands",
                       country_or_region: "vi"
                   }, {
                       name: "Uruguay",
                       country_or_region: "uy"
                   }, {
                       name: "Uzbekistan (Oʻzbekiston)",
                       country_or_region: "uz"
                   }, {
                       name: "Vanuatu",
                       country_or_region: "vu"
                   }, {
                       name: "Vatican City (Città del Vaticano)",
                       country_or_region: "va"
                   }, {
                       name: "Venezuela",
                       country_or_region: "ve"
                   }, {
                       name: "Vietnam (Việt Nam)",
                       country_or_region: "vn"
                   }, {
                       name: "Wallis and Futuna",
                       country_or_region: "wf"
                   }, {
                       name: "Western Sahara (‫الصحراء الغربية‬‎)",
                       country_or_region: "eh"
                   }, {
                       name: "Yemen (‫اليمن‬‎)",
                       country_or_region: "ye"
                   }, {
                       name: "Zambia",
                       country_or_region: "zm"
                   }, {
                       name: "Zimbabwe",
                       country_or_region: "zw"
                   } ]*/
            }

        },
        computed:{
            country_or_region(){
                return this.language.country_or_region || '';
            },
            country_or_region_name(){
                if(this.isLanguage){
                    return this.language.language || '';
                }
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
    }*/
    .flag.de{
        height:12px;
        background-position:-1269px 0px
    }
    /*.flag.dg{
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
    }*/
    .flag.it{
        height:14px;
        background-position:-2523px 0px
    }/*
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
