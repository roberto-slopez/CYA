import React from 'react';
import $ from 'jquery';
import SelectField from 'material-ui/lib/select-field';
import MenuItem from 'material-ui/lib/menus/menu-item';

var SelectFieldPais = React.createClass({
    getInitialState: function () {
        return {data: [], value: null};
    },

    handleChange: function (event, index, value) {
        this.setState({value: value});
    },

    componentDidMount: function () {
        let array = [];
        $.ajax({
            url: this.props.source,
            dataType: 'json',
            contentType: "charset=utf-8",
            cache: false,
            context: this,
            success: function(data) {
                data.map(function (country) {
                    array.push(<MenuItem key={country.code} value={country.code} primaryText={country.name}/>);
                });
                this.setState({data: array});
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    },

    render: function () {
        return (
            <SelectField value={this.state.value} onChange={this.handleChange} source="http://beta.json-generator.com/api/json/get/4JUuXEAde">
                { this.state.data }
            </SelectField>
        );
    }
});

export default SelectFieldPais;