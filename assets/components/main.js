import React from "react";
import {Link, Route, Routes} from "react-router-dom";
import InputProduct from "./input-product";
import InputSubscriber from "./input-subscriber";
import InputContract from "./input-contract";
import Report from "./report";

export default function  Main () {

    return (
        <div>
            <nav>
                <div className="nav-wrapper">
                    <ul id="nav-mobile" className="left hide-on-med-and-down">
                        <li><a href='/'>Home</a></li>
                        <li><Link to='/product' >Ввод тарифного плана</Link></li>
                        <li><Link to='/subscriber' >Ввод абонента</Link></li>
                        <li><Link to='/contract' >Подключение абонента</Link></li>
                        <li><Link to='/report' >Отчеты</Link></li>
                        <li><a href='/login'><i className="Medium material-icons">supervisor_account</i></a></li>
                        <li><a href='/logout'><i className="Medium material-icons">exit_to_app</i></a></li>
                    </ul>
                </div>
            </nav>

        <Routes>
            <Route path='/' element={null} />
            <Route path='/product' element={<InputProduct/>} />
            <Route path='/subscriber' element={<InputSubscriber/>} />
            <Route path='/contract' element={<InputContract/>} />
            <Route path='/report' element={<Report/>} />
        </Routes>
        </div>
    )
} 
