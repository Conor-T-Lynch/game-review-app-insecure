// @Reference: https://learn.cypress.io/testing-your-first-application/how-to-test-forms-and-custom-cypress-commands (accessed Jul. 22, 2024).
// @Reference: https://docs.cypress.io/app/faq
// @Reference: https://medium.com/@mohamedsaidibrahim/best-practices-for-cypress-io-custom-commands-in-typescript-and-javascript-0d76511d5589
// @Reference: https://docs.cypress.io/api/commands/type

describe("User Login", () => {
  // before each test, visit the login page
  beforeEach(() => {
    cy.visit("http://localhost/game-review-app-insecure/public/login.php");
  });
  // test case for successful log-in
  it("should allow a user to log in successfully", () => {
    // type a valid email into the input field
    cy.get('input[name="email"]').type("test1@example.com");
    // type a valid password into the input field
    cy.get('input[name="password"]').type("SecurePass123!");

    // click the login button to submit the login form
    cy.get('button[type="submit"]').click();

    // verify that the user is redirected to the homepage after logging in
    cy.url().should("include", "/index.php");
  });
  // test case for checking if the user credentails are incorrect
  it("should show an error if login credentials are incorrect", () => {
    // type a invalid email into the input field
    cy.get('input[name="email"]').type("test6@example.com");
    // type a invalid password into the input field
    cy.get('input[name="password"]').type("SecurePass123");

    // click the login button to submit the login form
    cy.get('button[type="submit"]').click();

    // check to see if the correct error message is displyed
    cy.contains("Invalid credentials").should("be.visible");
  });
  // test case to check all fields are required before submission
  it("should require both email and password fields", () => {
    // click the submit button without filling out any fields
    cy.get('button[type="submit"]').click();

    // check if the browser validation message appears
    cy.get('input[name="email"]').then(($input) => {
      expect($input[0].validationMessage).to.include("Please fill in this field");
    });

    // check if the browser validation message appears
    cy.get('input[name="password"]').then(($input) => {
      expect($input[0].validationMessage).to.include("Please fill in this field");
    });
  });
});
