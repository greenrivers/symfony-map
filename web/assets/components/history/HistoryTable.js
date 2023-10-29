import React, {useState} from 'react';
import {
    CircularProgress,
    Paper,
    Table,
    TableContainer,
    TablePagination,
} from '@mui/material';
import TableHead from './history-table/TableHead';
import TableBody from './history-table/TableBody';

const HistoryTable = (props) => {
    const rowsPerPage = 10;
    const {histories} = props;
    const [page, setPage] = useState(0);

    const handlePageChange = (event, newPage) => {
        setPage(newPage);
    }

    return (
        <div className="history-table">
            {
                histories ?
                    <Paper sx={{width: '100%'}}>
                        <TableContainer>
                            <Table sx={{minWidth: 750}} aria-labelledby="tableTitle" size={'small'}>
                                <TableHead/>
                                <TableBody rowsPerPage={rowsPerPage} page={page} histories={histories}/>
                            </Table>
                        </TableContainer>
                        <TablePagination
                            rowsPerPageOptions={[rowsPerPage]}
                            component="div"
                            count={histories.length}
                            rowsPerPage={rowsPerPage}
                            page={page}
                            showFirstButton
                            showLastButton
                            onPageChange={handlePageChange}
                        />
                    </Paper> :
                    <CircularProgress/>
            }
        </div>
    );
}

export default HistoryTable;
