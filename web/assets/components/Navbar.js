import React from 'react';
import {AppBar, Toolbar} from '@mui/material';
import Logo from './navbar/Logo';
import Menu from './navbar/Menu';

const Navbar = () => (
    <div className="navbar">
        <AppBar component="nav">
            <Toolbar>
                <Logo/>
                <Menu/>
            </Toolbar>
        </AppBar>
    </div>
);

export default Navbar;
