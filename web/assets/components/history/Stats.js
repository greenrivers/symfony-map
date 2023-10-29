import React from 'react';
import {
    Box,
    CircularProgress,
    Grid,
    Paper,
    styled
} from '@mui/material';
import {useTranslation} from 'react-i18next';

const Stats = (props) => {
    const {stats, statsLoader, historiesLength} = props;
    const {t} = useTranslation();

    const Item = styled(Paper)(({theme}) => ({
        backgroundColor: theme.palette.mode === 'dark' ? '#1A2027' : '#FFFFFF',
        ...theme.typography.body2,
        padding: theme.spacing(2),
        textAlign: 'center',
        color: theme.palette.text.secondary,
    }));

    return (
        <div className="stats">
            {
                statsLoader ?
                    <CircularProgress/> :
                    (
                        stats &&
                        <Box sx={{flexGrow: 1, background: '#DBEAFF'}} mt={10} py={5}>
                            <Grid container spacing={{xs: 4, md: 6}} justifyContent={'center'}>
                                <Grid item xs={10} md={2}>
                                    <Item>{t('stats.temperature.min')}: {stats.minTemperature}&#8451;</Item>
                                </Grid>
                                <Grid item xs={10} md={2}>
                                    <Item>{t('stats.temperature.max')}: {stats.maxTemperature}&#8451;</Item>
                                </Grid>
                                <Grid item xs={10} md={2}>
                                    <Item>{t('stats.temperature.avg')}: {stats.avgTemperature}&#8451;</Item>
                                </Grid>
                                <Grid item xs={10} md={2}>
                                    <Item>{t('stats.city')}: {stats.mostFrequentCity}</Item>
                                </Grid>
                                <Grid item xs={10} md={2}>
                                    <Item>{t('stats.all')}: {historiesLength}</Item>
                                </Grid>
                            </Grid>
                        </Box>
                    )
            }
        </div>
    );
}

export default Stats;
