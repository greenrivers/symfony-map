import React from 'react';
import {
    Dialog,
    DialogContent,
    DialogContentText,
    DialogTitle,
    IconButton
} from '@mui/material';
import {useTranslation} from 'react-i18next';

const Alert = (props) => {
    const {message} = props;
    const [open, setOpen] = React.useState(true);
    const {t} = useTranslation();

    const handleClose = () => {
        setOpen(false);
    };

    return (
        <div>
            <Dialog
                open={open}
                onClose={handleClose}
                aria-labelledby="alert-dialog-title"
                aria-describedby="alert-dialog-description"
            >
                <DialogTitle id="alert-dialog-title" style={{position: "relative"}}>
                    {t('alert.title')}
                    <IconButton onClick={handleClose} style={{position: "absolute", top: "0", right: "0"}}>
                        x
                    </IconButton>
                </DialogTitle>
                <DialogContent>
                    <DialogContentText id="alert-dialog-description">
                        {message}
                    </DialogContentText>
                </DialogContent>
            </Dialog>
        </div>
    );
}

export default Alert;
