import React from 'react';
import {
    TableBody as MuiTableBody,
    TableCell,
    TableRow
} from '@mui/material';

const TableBody = (props) => {
    const {rowsPerPage, page, histories} = props;

    return (
        <MuiTableBody>
            {(rowsPerPage > 0
                    ? histories.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)
                    : histories
            ).map((history, index) => (
                <TableRow hover sx={{height: 40}} key={index} tabIndex={-1}>
                    <TableCell component="th" scope="row" align="center">
                        {page * rowsPerPage + index + 1}
                    </TableCell>
                    <TableCell align="center">{history.temperature}&#8451;</TableCell>
                    <TableCell align="center">{history.cloudiness}%</TableCell>
                    <TableCell align="center">{history.wind} m/s</TableCell>
                    <TableCell align="center">{history.description}</TableCell>
                    <TableCell align="center">{history.lat}&deg; {history.lng}&deg;</TableCell>
                    <TableCell align="center">{history.city ? history.city : '-'}</TableCell>
                    <TableCell align="center">
                        {new Date(history.dateTime).toLocaleString()}
                    </TableCell>
                </TableRow>
            ))}
        </MuiTableBody>
    );
}

export default TableBody;
