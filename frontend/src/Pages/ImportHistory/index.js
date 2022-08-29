import React, { useEffect, useState } from 'react';
import NumberFormat from 'react-number-format';
import Navigation from "../../Components/Navbar";
import Card from "../../Components/Card";
import backendUrl from "../../config.js";
import './styles.css'

const ImportHistory = () => {
    const [isLoaded, setIsLoaded] = useState(false)
    const [items, setItems] = useState([])

    useEffect(() => {  
        setIsLoaded(true)
        getImportHistory()
    }, [])

    const getImportHistory = () => {
        
        fetch(backendUrl + 'importhistory')
            .then(res => res.json())
            .then(
                (result) => {
                    setItems(result.data)
                    console.log(result.data);
                },
                (error) => {
                    alert('Ops! erro ao buscar os dados')
                }
            )
    }

    const revertImportHistory = (id) => {
        const formData = new FormData();
		formData.append('id', id);
        
        fetch(backendUrl + 'importhistory/toreverse', 
                {
                    method: 'POST',
                    body: formData,
                })
            .then(res => res.json())
            .then(
                () => {
                    getImportHistory()
                },
                (error) => {
                    alert('Erro ao reverter a importação')
                    console.log(error)
                }
            )
    }

    if (!isLoaded) {
        return <div>Loading...</div>;
    } else {

        return (
            <div className="container">
                <Navigation />
                <div className="content">
                <br />
                    <h1>Lista de Transações</h1>

                    <Card>
                        <br />
                        <table>
                            <thead>
                                <tr>
                                    <th style={{width:'15%'}}>Id</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                    <th>Reverter</th>
                                </tr>
                            </thead>
                            <tbody>
                            {items.length > 0 ? (
                                items.map(importhistory => {
                                return (
                                    <tr key={importhistory.id}>
                                        <td>{importhistory.id}</td>
                                        <td>{importhistory.date}</td>
                                        <td>{importhistory.status}</td>
                                        <td>
                                            {importhistory.status === "importado" && (
                                                <button className='slim' onClick={ () => revertImportHistory(importhistory.id) }>reverter</button>
                                            )}
                                        </td>
                                    </tr>
                                )
                            })) : (
                                <tr>
                                    <td colSpan={8}>
                                        Carregando ...
                                    </td>
                                </tr>
                            )}
                            </tbody>
                        </table>
                    </Card>
            
                </div>
            </div>
        )
    }
}

export default ImportHistory;