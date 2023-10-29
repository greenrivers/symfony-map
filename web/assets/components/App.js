import React from 'react';
import {BrowserRouter, Route, Routes} from 'react-router-dom';
import Map from './Map';
import History from './History';
import Navbar from './Navbar';

const App = () => {
    const MapRoute = ['/', '/en', '/pl']
        .map(path => <Route path={path} element={<Map/>} key={path}/>);
    const HistoryRoute = ['/history', '/en/history', '/pl/history']
        .map(path => <Route path={path} element={<History/>} key={path}/>);

    return (<BrowserRouter>
        <div className="app">
            <Navbar/>
            <Routes>
                {MapRoute}
                {HistoryRoute}
            </Routes>
        </div>
    </BrowserRouter>);
}

export default App;
