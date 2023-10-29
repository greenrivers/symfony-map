import React from 'react';
import {NavLink as RouterLink} from 'react-router-dom';
import {Box} from '@mui/material';
import {useTranslation} from 'react-i18next';

const Menu = () => {
    const locale = window.location.pathname.split('/')[1];
    const {t} = useTranslation();

    return (
        <Box className="menu" sx={{display: 'flex', gap: '25px'}}>
            <RouterLink to={locale ? locale : '/'} end className="link">
                {t('navbar.map')}
            </RouterLink>
            <RouterLink to={locale ? locale + '/history' : '/history'} className="link">
                {t('navbar.history')}
            </RouterLink>
        </Box>
    );
}

export default Menu;
