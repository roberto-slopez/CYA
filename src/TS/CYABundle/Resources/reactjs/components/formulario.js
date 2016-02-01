import React from 'react';
const {Grid, Row, Col} = require('react-flexgrid');
import SelectFieldPais from './selectFieldPais';
import SelectFieldCurso from './selectFieldCurso';
import ResultPrice from './resultPrice';

class Formulario extends React.Component {
    render() {
        return (
            <form>
            <Row className="center-md">
                <Col sm={12} lg={4}><SelectFieldCurso source="http://beta.json-generator.com/api/json/get/EJUqMwJte" /></Col>
                <Col sm={12} lg={4}><SelectFieldPais source="http://beta.json-generator.com/api/json/get/4JUuXEAde" /></Col>
                <Col sm={12} lg={4}><ResultPrice /></Col>
            </Row>
            </form>
        );
    }
}

export default Formulario;
