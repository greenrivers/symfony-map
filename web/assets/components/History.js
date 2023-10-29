import React, {useEffect, useState} from 'react';
import {Box} from '@mui/material';
import axios from 'axios';
import Stats from './history/Stats';
import HistoryTable from './history/HistoryTable';

const History = () => {
    const [histories, setHistories] = useState([]);
    const [stats, setStats] = useState({});
    const [statsLoader, setStatsLoader] = useState(true);

    useEffect(() => {
        loadHistories();
        loadStats();
    }, []);

    const loadHistories = async () => {
        await axios.get(`${origin}/api/histories`).then((response) => {
            const {data} = response;
            setHistories(data);
        }).catch((error) => {
            const {message} = error.response.data;
            console.error(message);
        });
    }

    const loadStats = async () => {
        await axios.get(`${origin}/api/stats`).then((response) => {
            const {data} = response;
            setStats(data);
        }).catch((error) => {
            const {message} = error.response.data;
            console.error(message);
        }).finally(() => {
            setStatsLoader(false);
        });
    }

    return (
        <div className="history">
            <Box sx={{width: '100%'}}>
                <HistoryTable histories={histories}/>
                <Stats stats={stats} statsLoader={statsLoader} historiesLength={histories.length}/>
            </Box>
        </div>
    );
}

export default History;
