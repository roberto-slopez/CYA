import React from 'react';
import Card from 'material-ui/lib/card/card';

import List from 'material-ui/lib/lists/list';
import ListItem from 'material-ui/lib/lists/list-item';
import ActionGrade from 'material-ui/lib/svg-icons/action/grade';
import ActionInfo from 'material-ui/lib/svg-icons/action/info';
import ContentInbox from 'material-ui/lib/svg-icons/content/inbox';
import ContentDrafts from 'material-ui/lib/svg-icons/content/drafts';
import ContentSend from 'material-ui/lib/svg-icons/content/send';
import Divider from 'material-ui/lib/divider';

import TextField from 'material-ui/lib/text-field';
import RaisedButton from 'material-ui/lib/raised-button';

const ResultPrice = () => (
    <Card>
        <List>
          <ListItem primaryText="CURSO" leftIcon={<ContentInbox />} secondaryText="$ 800.0U SD"/>
          <ListItem primaryText="REGISTRO" leftIcon={<ActionGrade />} secondaryText="$ 800.0U SD"/>
          <ListItem primaryText="MATERIALES" leftIcon={<ContentSend />} secondaryText="$ 800.0U SD"/>
          <ListItem primaryText="ESTADIA" leftIcon={<ContentDrafts />} secondaryText="$ 800.0U SD"/>
          <Divider />
          <ListItem primaryText="TRASLADO" leftIcon={<ContentInbox />} secondaryText="$ 800.0U SD"/>
          <ListItem primaryText="FINANCIEROS" leftIcon={<ContentInbox />} secondaryText="$ 800.0U SD"/>
          <ListItem primaryText="ASISTENCIA" leftIcon={<ContentInbox />} secondaryText="$ 800.0U SD"/>
          <ListItem primaryText="VISA" leftIcon={<ContentInbox />} secondaryText="$ 800.0U SD"/>
          <Divider />
          <ListItem primaryText="TOTAL" leftIcon={<ContentInbox />} secondaryText="$ 800.0U SD"/>
          <Divider />
          <ListItem primaryText="PESOS" leftIcon={<ContentInbox />} secondaryText="$ 800.0U SD"/>
          <Divider />
        </List>
        <RaisedButton label="IMPRIMIR" primary={true} />
        <RaisedButton label="NUEVA" secondary={true} />
    </Card>
);

export default ResultPrice;
