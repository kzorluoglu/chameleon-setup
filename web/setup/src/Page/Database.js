import Image from 'react-bootstrap/Image';
import Button from 'react-bootstrap/Button';
import Form from 'react-bootstrap/Form';
import Col from 'react-bootstrap/Col';
import Row from 'react-bootstrap/Row';
import {
    BsArrowRepeat,
    BsFillArrowLeftSquareFill,
    BsFillArrowRightSquareFill,
} from "react-icons/bs";
import {Component} from "react";
import {LinkContainer} from "react-router-bootstrap";
import InputGroup from 'react-bootstrap/InputGroup';


export default class Database extends Component {

    constructor(props) {
        super(props);

        this.state = {
            database: {
                type: 'mysql',
                path: null,
                name: null,
                username: null,
                password: null,
                port: null,
            },
            installable: false,
            error: null
        }

    }

    componentDidMount() {
        this.handleMysqlDriverOptionChange = this.handleMysqlDriverOptionChange.bind(this)
        this.isDatabaseValid = this.isDatabaseValid.bind(this)
    }

    checkMysqlDatabaseConnection(database) {

        const requestOptions = {
            method: 'POST',
            body: JSON.stringify(database)
        };

        console.log(requestOptions)

        fetch("http://localhost:3333/setup/index.php?page=databasevalidation", requestOptions)
            .then(res => {
                return res.json()
            })
            .then((result) => {
                    this.setState({
                        installable: result.dbConnection,
                        database: result.databaseInformation
                    })
                },
                (error) => {
                    this.setState({
                        isLoaded: true,
                        error: {
                            message: error
                        }
                    })
                })
    }


    checkSqliteDatabaseConnection(database) {

    }

    isDatabaseValid = () => {

        if (this.state.database.type === 'mysql') {
            console.log(this.state.database)
            this.checkMysqlDatabaseConnection({
                type: document.getElementById('database-type').value,
                hostname: document.getElementById('database-hostname').value,
                port: document.getElementById('database-port').value,
                name: document.getElementById('database-name').value,
                username: document.getElementById('database-username').value,
                password: document.getElementById('database-password').value,
                install_demo_data: document.getElementById('install_demo_data').value,
            })
        }

        if (this.state.database.type === 'sqlite') {
            this.checkSqliteDatabaseConnection({
                type: document.getElementById('database-type').value,
                path: document.getElementById('database-path').value,
                install_demo_data: document.getElementById('install_demo_data').value
            })
        }

    }

    handleMysqlDriverOptionChange = (e) => {
        this.setState({
            database: {
                type: e.target.value
            }
        });

    }

    render() {
        const {database, installable, error} = this.state;

        return (
            <Row>
                <Col>
                    <div className="p-5">
                        <div className="mb-5">
                            <span className="badge bg-secondary">Step 3</span>
                            <h3 className="h4 font-weight-bold text-theme">Database Validation</h3>
                        </div>
                        <form onSubmit={this.isDatabaseValid}>
                            <InputGroup className="mb-3">
                                <InputGroup.Text id="inputGroup-database-driver">
                                    Database Driver
                                </InputGroup.Text>
                                <Form.Select onChange={this.handleMysqlDriverOptionChange} id="database-type">
                                    <option value="mysql">MySQL</option>
                                    <option value="sqlite">SQLite</option>
                                </Form.Select>
                            </InputGroup>
                            {database.type === 'sqlite' && (
                                <div>
                                    <br/>
                                    <InputGroup className="mb-3">
                                        <InputGroup.Text id="inputGroup-database-path">
                                            Database Path
                                        </InputGroup.Text>
                                        <Form.Control
                                            required
                                            aria-label="Database Path"
                                            aria-describedby="inputGroup-sizing-default"
                                            id="database-path"
                                        />
                                    </InputGroup>
                                </div>
                            )}
                            {database.type === 'mysql' && (
                                <div>
                                    <br/>
                                    <InputGroup className="mb-3">
                                        <InputGroup.Text id="inputGroup-database-hostname">
                                            Database Hostname
                                        </InputGroup.Text>
                                        <Form.Control
                                            required
                                            aria-label="Database Hostname"
                                            aria-describedby="inputGroup-sizing-default"
                                            id="database-hostname"

                                        />
                                    </InputGroup>
                                    <br/>
                                    <InputGroup className="mb-3">
                                        <InputGroup.Text id="inputGroup-database-port">
                                            Database Port
                                        </InputGroup.Text>
                                        <Form.Control
                                            required
                                            value="3306"
                                            aria-label="Database Port"
                                            aria-describedby="inputGroup-sizing-default"
                                            id="database-port"

                                        />
                                    </InputGroup>
                                    <br/>
                                    <InputGroup className="mb-3">
                                        <InputGroup.Text id="inputGroup-database-name">
                                            Database Name
                                        </InputGroup.Text>
                                        <Form.Control
                                            required
                                            aria-label="Database Name"
                                            aria-describedby="inputGroup-sizing-default"
                                            id="database-name"
                                        />
                                    </InputGroup>
                                    <br/>
                                    <InputGroup className="mb-3">
                                        <InputGroup.Text id="inputGroup-database-username">
                                            Database Username
                                        </InputGroup.Text>
                                        <Form.Control
                                            required
                                            aria-label="Database Username"
                                            aria-describedby="inputGroup-sizing-default"
                                            id="database-username"
                                        />
                                    </InputGroup>
                                    <br/>
                                    <InputGroup className="mb-3">
                                        <InputGroup.Text id="inputGroup-database-password">
                                            Database Password
                                        </InputGroup.Text>
                                        <Form.Control
                                            required
                                            id="database-password"
                                            type="password"
                                            aria-label="Database Password"
                                            aria-describedby="inputGroup-sizing-default"
                                        />
                                    </InputGroup>
                                </div>
                            )}
                            <Form.Check
                                type="checkbox"
                                id="install_demo_data"
                                label="Install with Demo Data"
                            />
                            <br/>

                            <Row>
                                <Col>
                                    <LinkContainer to="/">
                                        <Button variant="primary"><BsFillArrowLeftSquareFill/> Install</Button>
                                    </LinkContainer>
                                </Col>
                                <Col>
                                    {installable ?
                                        <LinkContainer to="/databaseInstallation">
                                            <Button variant="primary"><BsFillArrowRightSquareFill/> Database
                                                Installation</Button>
                                        </LinkContainer>
                                        :
                                        <Button variant="primary" onClick={this.isDatabaseValid}>
                                            <BsArrowRepeat/> Check
                                        </Button>
                                    }
                                </Col>
                            </Row>
                        </form>
                    </div>


                </Col>
                <Col>
                    <Image src="https://www.esono.de/chameleon/mediapool/7/fa/packshot_id4191.png"/>
                </Col>
            </Row>);
    }

}