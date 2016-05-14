var LoginForm = React.createClass({

    render: function() {
        return (
            <div>
                <div className="form-group">
                    <label htmlFor="usernameInput">Name</label>
                    <input type="text" className="form-control" id="nameInput" name="nameInput" ref="nameInput" defaultValue={this.props.data.name} required/>
                </div>
                <div className="form-group">
                    <label htmlFor="usernameInput">Username</label>
                    <input type="text" className="form-control" id="usernameInput" name="siteUsername" ref="siteUsername" defaultValue={this.props.data.user}  required/>
                </div>
                <div className="form-group">
                    <label htmlFor="passwordInput">Password</label>
                    <input type="password" className="form-control" id="passwordInput" name="sitePassword" ref="sitePassword" defaultValue={this.props.data.password} required/>
                </div>
                <div className="form-group">
                    <label htmlFor="sitenameInput">Site Name</label>
                    <input type="text" className="form-control" id="sitenameInput" name="siteSitename" ref="siteSitename" defaultValue={this.props.data.site} required/>
                </div>
            </div>
        );
    }
});

var PasswordContent = React.createClass({
    getInitialState: function () {
        return {
            data: [],
            contentState: "1"
        };
    },
    componentDidMount: function () {
        $.ajax({
            url: this.props.url+document.getElementById('content').value,
            dataType: 'json',
            cache: false,
            success: function(data) {
                this.setState({data: data});
            }.bind(this),
            error: function(data, status, err) {
                console.log(this.props.url, status, err.toString());
            }.bind(this)
        });
    },
    handleSubmit: function(e) {
        e.preventDefault();
        if (this.state.data.categoryId == 1) {
            var name = this.refs.loginform.refs.nameInput.value;
            var siteUsername = this.refs.loginform.refs.siteUsername.value;
            var sitePasword = this.refs.loginform.refs.sitePassword.value;
            var siteSitename = this.refs.loginform.refs.siteSitename.value;
            var senddata = {'name': name,'category': this.state.data.categoryId, 'siteUsername': siteUsername, 'sitePasword': sitePasword, 'siteSitename': siteSitename};
        } else {
            if (this.state.data.categoryId == 2) {
                content = <CreditCardForm ref="creditcardform" data={data} />;
            } else {
                if (this.state.data.categoryId == 3) {
                    content = <NoteForm ref="noteform" data={data} />;
                }
            } 
        }
        $.ajax({
            url: "/password/update/" + document.getElementById('content').value,
            type: "POST",
            data: JSON.stringify({ senddata: senddata }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            complete: function(xhr, textStatus) {
                $( "#message" ).text( xhr.responseText );
                $('.modal-success').modal('show');
            },
            failure: function(errMsg) {
                $( "#message" ).text( errMsg );
                $('.modal-danger').modal('show');
            }
        });
    },
    render: function () {
        var content = 'Loading...';
        if (this.state.data.categoryId == 1) {
                content = <LoginForm ref="loginform" data={this.state.data} />
        } else {
            if (this.state.data.categoryId == 2) {
                content = <CreditCardForm ref="creditcardform" data={data} />;
            } else {
                if (this.state.data.categoryId == 3) {
                    content = <NoteForm ref="noteform" data={data} />;
                }
            } 
        }
        $('#reveal').click(function() {
            if (document.getElementById('reveal').text == 'Reveal') {
                document.getElementById('passwordInput').type = 'text';
                document.getElementById('reveal').text = 'Hide';
            } else {
                document.getElementById('passwordInput').type = 'password';
                document.getElementById('reveal').text = 'Reveal';
            }
        });
        return (
            <form onSubmit={this.handleSubmit}>
                {content}
                <button type="submit" className="btn btn-default">Update</button>&nbsp;
                <a id="reveal" className="btn btn-danger">Reveal</a>&nbsp;
                <a href="javascript:history.go(-1)" className="btn btn-default">Return</a>
            </form>
        );
    }
});

ReactDOM.render(
  <PasswordContent url='/password/getContent/'/>,
  document.getElementById('retrieve_password')
);