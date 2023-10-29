import i18n from 'i18next';
import {initReactI18next} from 'react-i18next';
import enYaml from '../../translations/messages.en.yml';
import plYaml from '../../translations/messages.pl.yml';

i18n
    .use(initReactI18next)
    .init({
        resources: {
            en: {
                translation: enYaml,
            },
            pl: {
                translation: plYaml,
            }
        },
        lng: (window && window.locale) || 'en',
        fallbackLng: 'en',
    });

export default i18n;
