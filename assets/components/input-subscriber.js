import React from "react";

export default function  InputSubscriber () {

    return (
        <div>
            <li className="collection-header"><h4>Ввод абонента</h4></li>
            <div className="row">
                <form className="col s6">

                    <div className="row">
                        <div className="input-field col s12">
                            <input value="" id="name" type="text" className="validate"></input>
                                <label htmlFor="name">ФИО</label>
                        </div>
                    </div>
                    <div className="row">
                        <div className="input-field col s12">
                            <input id="street" type="text" className="validate"></input>
                                <label htmlFor="street">Город, улица</label>
                        </div>
                    </div>
                    <div className="row">
                        <div className="input-field col s6">
                            <input id="house" type="text" className="validate"></input>
                            <label htmlFor="house">Дом</label>
                        </div>
                        <div className="input-field col s6">
                            <input id="apartment" type="text" className="validate"></input>
                            <label htmlFor="apartment">Квартира</label>
                        </div>
                    </div>

                    <button className="btn waves-effect waves-light" type="submit" name="action">Submit</button>

                </form>
            </div>

        </div>
    );
}