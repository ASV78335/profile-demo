import React, {Component} from "react";
import M from "../lib/materialize";

export default class InputContract extends Component {

    componentDidMount() {
        let elems = document.querySelectorAll('select');
        let instances = M.FormSelect.init(elems);
    }

    render () {
        return (
            <div>
                <li className="collection-header"><h4>Подключение абонента</h4></li>
                <div className="row">
                    <form className="col s6">
                        <div className="row">
                            <div className="input-field col s12">
                                <select name="product" value="">
                                    <option value="" disabled selected>Выберите тарифный план</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                </select>
                                <label>Тарифный план</label>
                            </div>
                        </div>
                        <div className="row">
                            <div className="input-field col s12">
                                <select name="subscriber">
                                    <option value="" disabled selected>Выберите абонента</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                </select>
                                <label>Абонент</label>
                            </div>
                        </div>
                        <div className="row">
                            <div className="input-field col s12">
                                <input id="signedAt" type="date" className="datepicker"></input>
                                <label htmlFor="fullName">Дата подключения</label>
                            </div>
                        </div>

                        <button className="btn waves-effect waves-light" type="submit" name="action">Submit</button>

                    </form>
                </div>

            </div>
        );
    }
}