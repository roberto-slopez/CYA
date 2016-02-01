/** In this file, we create a React component which incorporates components provided by material-ui */

import React from 'react';
const {Grid, Row, Col} = require('react-flexgrid');

import RaisedButton from 'material-ui/lib/raised-button';
import ThemeManager from 'material-ui/lib/styles/theme-manager';
import LightRawTheme from 'material-ui/lib/styles/raw-themes/light-raw-theme';
import Colors from 'material-ui/lib/styles/colors';
import FlatButton from 'material-ui/lib/flat-button';

import Card from 'material-ui/lib/card/card';
import CardActions from 'material-ui/lib/card/card-actions';
import CardHeader from 'material-ui/lib/card/card-header';
import CardMedia from 'material-ui/lib/card/card-media';
import CardTitle from 'material-ui/lib/card/card-title';
import CardText from 'material-ui/lib/card/card-text';
import Formulario from './formulario';

const containerStyle = {
    paddingTop: 200
};

const Main = React.createClass({
    childContextTypes: {
        muiTheme: React.PropTypes.object
    },

    getInitialState() {
        return {
            muiTheme: ThemeManager.getMuiTheme(LightRawTheme),
            open: false,
        };
    },

    getChildContext() {
        return {
            muiTheme: this.state.muiTheme
        };
    },

    componentWillMount() {
        let newMuiTheme = ThemeManager.modifyRawThemePalette(this.state.muiTheme, {
            accent1Color: Colors.teal500
        });

        this.setState({muiTheme: newMuiTheme});
    },

    _handleRequestClose() {
        this.setState({
            open: false
        });
    },

    _handleTouchTap() {
        this.setState({
            open: true
        });
    },
    render() {
        const standardActions = (
            <FlatButton
                label="Okey"
                secondary={true}
                onTouchTap={this._handleRequestClose}
            />
        );
        return (
            <div style={containerStyle}>
            <Grid>
                <Card>
                <Row>
                    <Col md={12}>
                    <CardTitle title="Cotizador" subtitle="Consejería, Estudios en el exterior"/>
                    </Col>
                </Row>
                <Row>
                    <Col md={12}>
                        <CardActions>
                        <Formulario />
                        </CardActions>
                        <CardText>
                            Ejemplo de funcionamiendo de ReactJS
                        </CardText>
                    </Col>
                </Row>
                </Card>
            </Grid>
            </div>
        );
    }
});

export default Main;
