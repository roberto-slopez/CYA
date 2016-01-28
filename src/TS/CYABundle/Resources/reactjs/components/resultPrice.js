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

const ResultPrice = () => (
    <Card>
        <List>
          <ListItem primaryText="CURSO" leftIcon={<ContentInbox />} rightIcon={<TextField hintText="USD" disabled={true} floatingLabelText="800.00" />} />
          <ListItem primaryText="REGISTRO" leftIcon={<ActionGrade />} rightIcon={<TextField hintText="USD" disabled={true} floatingLabelText="800.00" />} />
          <ListItem primaryText="MATERIALES" leftIcon={<ContentSend />} rightIcon={<TextField hintText="USD" disabled={true} floatingLabelText="800.00" />} />
          <ListItem primaryText="ESTADIA" leftIcon={<ContentDrafts />} rightIcon={<TextField hintText="USD" disabled={true} floatingLabelText="800.00" />} />
          <Divider />
          <ListItem primaryText="TRASLADO" leftIcon={<ContentInbox />} rightIcon={<TextField hintText="USD" disabled={true} floatingLabelText="800.00" />} />
          <ListItem primaryText="FINANCIEROS" leftIcon={<ContentInbox />} rightIcon={<TextField hintText="USD" disabled={true} floatingLabelText="800.00" />} />
          <ListItem primaryText="ASISTENCIA" leftIcon={<ContentInbox />} rightIcon={<TextField hintText="USD" disabled={true} floatingLabelText="800.00" />} />
          <ListItem primaryText="VISA" leftIcon={<ContentInbox />} rightIcon={<TextField hintText="USD" disabled={true} floatingLabelText="800.00" />} />
          <Divider />
          <ListItem primaryText="TOTAL" leftIcon={<ContentInbox />} rightIcon={<TextField hintText="USD" disabled={true} floatingLabelText="800.00" />} />
          <Divider />
          <ListItem primaryText="PESOS" leftIcon={<ContentInbox />} rightIcon={<TextField hintText="USD" disabled={true} floatingLabelText="800.00" />} />
          <Divider />
          <ListItem primaryText="IMPRIMIR" leftIcon={<ContentInbox />} />
          <ListItem primaryText="NUEVA" leftIcon={<ContentInbox />} />
        </List>
    </Card>
);

export default ResultPrice;
