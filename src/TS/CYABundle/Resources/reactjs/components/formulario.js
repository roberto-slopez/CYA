import React from 'react';
import SelectFieldPais from './selectFieldPais'
import SelectFieldCurso from './selectFieldCurso'
import ResultPrice from './resultPrice'

class Formulario extends React.Component {
    render() {
        return (
            <form>
                <SelectFieldCurso source="http://beta.json-generator.com/api/json/get/EJUqMwJte" />
                <br/>
                <SelectFieldPais source="http://beta.json-generator.com/api/json/get/4JUuXEAde" />
                <br/>
                <ResultPrice />
            </form>
        );
    }
}

export default Formulario;
