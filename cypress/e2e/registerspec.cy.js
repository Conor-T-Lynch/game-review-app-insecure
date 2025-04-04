// @Reference: https://learn.cypress.io/testing-your-first-application/how-to-test-forms-and-custom-cypress-commands (accessed Jul. 22, 2024).
// @Reference: https://docs.cypress.io/app/faq
// @Reference: https://medium.com/@mohamedsaidibrahim/best-practices-for-cypress-io-custom-commands-in-typescript-and-javascript-0d76511d5589
// @Reference: https://docs.cypress.io/api/commands/type

describe("User Registration", () => {
  // before each test, visit the registration page
  beforeEach(() => {
    cy.visit("http://localhost/game-review-app-secure/public/register.php");
  });
  // test case for successful registration
  it("should allow a user to register successfully", () => {
    // type a valid username into the input field
    cy.get('input[name="username"]').type("testuser2");
    // type a valid email into the input field
    cy.get('input[name="email"]').type(`test2@example.com`);
    // type a valid password into the input field
    cy.get('input[name="password"]').type("SecurePass123!");
    // click the submit button to register
    cy.get('button[type="submit"]').click();
    // after form submission, verify that the user is redirected to the login page
    cy.url().should("include", "/login.php");
    // check if the registration success message appears on the page
    cy.contains("Registration successful!").should("be.visible");
  });
  // test case for when an email is already registered
  it("should show an error if the email is already registered", () => {
    // set an email that is already registered in the database
    const existingEmail = "test2@example.com";
    // type a new user name into username input field
    cy.get('input[name="username"]').type("testuser3");
    // type the already registered email into the email input field
    cy.get('input[name="email"]').type(existingEmail);
    // type a valid password into the input field
    cy.get('input[name="password"]').type("SecurePass123!");
    // click the submit button to try registerwith an existing email
    cy.get('button[type="submit"]').click();
    // after submission verify that the error message for an already registered email appears
    cy.contains("Email is already registered! Please use a different email.").should("be.visible");
  });
  // test case to check all fields are required before submission
  it("should require all fields", () => {
    // click the submit button without filling out any fields
    cy.get('button[type="submit"]').click();
    // check if the browser validation message appears
    cy.get('input[name="username"]').then(($input) => {
      expect($input[0].validationMessage).to.include("Please fill in this field");
    });
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
