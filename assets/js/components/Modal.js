import React, { useState } from 'react';

const Modal = () => {
    const [show, setShow] = useState(false);

    const handleShow = () => setShow(true);
    const handleClose = () => setShow(false);

    return (
        <>
            <button type="button" className="btn btn-primary" onClick={handleShow}>
                Create New moneygone
            </button>

            <div className={`modal fade ${show ? 'show' : ''}`} id="memodal" style={{ display: show ? 'block' : 'none' }}>
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h4 className="modal-title">Record your expense</h4>
                            <button type="button" className="btn-close" onClick={handleClose}></button>
                        </div>
                        <div className="modal-body">
                            <form>
                                <div className="form-group">
                                    <label>Category</label>
                                    <input type="text" className="form-control" />
                                </div>
                                <div className="form-group">
                                    <label>Title</label>
                                    <input type="text" className="form-control" />
                                </div>
                                <div className="form-group">
                                    <label>Amount</label>
                                    <input type="number" className="form-control" />
                                </div>
                                <div className="form-group">
                                    <label>Date</label>
                                    <input type="date" className="form-control" />
                                </div>
                                <div className="form-group">
                                    <label>Notes</label>
                                    <textarea className="form-control"></textarea>
                                </div>
                                <button type="submit" className="btn btn-primary">Save ME!</button>
                            </form>
                        </div>
                        <div className="modal-footer">
                            <button type="button" className="btn btn-danger" onClick={handleClose}>Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Modal;
