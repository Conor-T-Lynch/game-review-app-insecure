// @Reference: https://learn.cypress.io/testing-your-first-application/how-to-test-forms-and-custom-cypress-commands (accessed Jul. 22, 2024).
// @Reference: https://docs.cypress.io/app/faq
// @Reference: https://medium.com/@mohamedsaidibrahim/best-practices-for-cypress-io-custom-commands-in-typescript-and-javascript-0d76511d5589
// @Reference: https://docs.cypress.io/api/commands/type

describe("Game Review Submission", () => {
  // before each test, visit the login page
  beforeEach(() => {
    // this method ensures that the session is maintained throughout test cases
    cy.request({
      method: "POST",
      url: "http://localhost/game-review-app-secure/public/login.php",
      form: true,
      body: {
        email: "test2@example.com",
        password: "SecurePass123!"
      }
    });

    // after logging in, navigate to the review submission page
    cy.visit("http://localhost/game-review-app-secure/public/review.php");
  });
  // test case to check if a user can submit a review
  it("should allow a user to submit a review successfully", () => {
    // fill in the form with valid review details for the game name
    cy.get('input[name="game_name"]').type("Elden Ring");
    // fill in the form with valid review details for the game review text
    cy.get('textarea[name="review_text"]').type("Amazing game with breathtaking visuals!");
    // fill in the form with valid review details for the games rating
    cy.get('input[name="rating"]').type("9");

    // click the submit button to post the review to the database and website
    cy.get('button[type="submit"]').click();

    // verify that the user is redirected to the homepage (index page) and that the success message appears
    cy.url().should("include", "/index.php");
    cy.contains("Review submitted successfully!").should("be.visible");
  });
  // test case to check all fields are required before submission
  it("should require all fields", () => {
    // click the submit button without filling out any fields
    cy.get('button[type="submit"]').click();

    // check if the browser validation message appears
    cy.get('input[name="game_name"]').then(($input) => {
      expect($input[0].validationMessage).to.include("Please fill in this field");
    });
    // check if the browser validation message appears
    cy.get('textarea[name="review_text"]').then(($input) => {
      expect($input[0].validationMessage).to.include("Please fill in this field");
    });
    // check if the browser validation message appears
    cy.get('input[name="rating"]').then(($input) => {
      expect($input[0].validationMessage).to.include("Please fill in this field");
    });
  });
  // test case to check for a valid game rating no greater the 10
  it("should validate the rating value", () => {
    // enters and invalid number for a rating that greater then 10
    cy.get('input[name="game_name"]').type("Dark Souls III");
    cy.get('textarea[name="review_text"]').type("A classic RPG with great combat mechanics.");
    cy.get('input[name="rating"]').type("15");

    // submits the form by clicking the submit button, the submission is expected to fail
    cy.get('button[type="submit"]').click();

    // checks to see if the user is still on the review page meaning that the submission has failed due to the invalid rating value
    cy.url().should("include", "/review.php");

    // confirms that no success message has been displayed indicating that the review submission was a success
    cy.contains("Review submitted successfully!").should("not.exist");
  });
});
