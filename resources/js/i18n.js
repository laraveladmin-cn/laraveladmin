import Vue from 'vue';
import VueI18n from 'vue-i18n'; //多语言设置
import { configure } from 'vee-validate';
configure({
    // this will be used to generate messages.
    defaultMessage: (field, values) => {
        values._field_ = i18n.t(`fields.${field}`);
        if(values._field_.indexOf('fields.')==0){
            values._field_ = field;
        }
        return i18n.t(`validations.messages.${values._rule_}`, values);
    }
});
Vue.use(VueI18n);
const locales = {
    'en':require('../lang/en/front.json')
};
const i18n = new VueI18n({
    locale: 'en',
    fallbackLocale: 'en',
    silentTranslationWarn: true,
    messages: locales,
});

export default i18n;

