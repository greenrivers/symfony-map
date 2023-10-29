import React from 'react';
import {
    TableCell,
    TableHead as MuiTableHead,
    TableRow
} from '@mui/material';
import {useTranslation} from 'react-i18next';

const TableHead = () => {
    const {t} = useTranslation();

    return (
        <MuiTableHead sx={{height: 60}}>
            <TableRow>
                <TableCell align="center">{t('history.id')}</TableCell>
                <TableCell align="center">{t('history.temperature')}</TableCell>
                <TableCell align="center">{t('history.cloudiness')}</TableCell>
                <TableCell align="center">{t('history.wind')}</TableCell>
                <TableCell align="center">{t('history.description')}</TableCell>
                <TableCell align="center">{t('history.position')}</TableCell>
                <TableCell align="center">{t('history.city')}</TableCell>
                <TableCell align="center">{t('history.dateTime')}</TableCell>
            </TableRow>
        </MuiTableHead>
    );
}

export default TableHead;
