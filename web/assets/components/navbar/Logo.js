import React from 'react';
import {Box, Link, Typography} from '@mui/material';
import logoPath from '../../images/logo.svg';

const Logo = () => {
    const GREENRIVERS_URL = 'https://greenrivers.pl';

    return (
        <Typography component="div" sx={{flexGrow: 1}}>
            <Link href={GREENRIVERS_URL} target="_blank">
                <Box
                    component="img"
                    sx={{
                        width: {xs: 120, md: 140}
                    }}
                    alt="Greenrivers"
                    src={logoPath}
                />
            </Link>
        </Typography>
    );
}

export default Logo;
