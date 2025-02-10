<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Webhook Form</title>

    <!-- Bootstrap 5 CDN -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
  </head>

  <body class="bg-light">
    <div class="container">
      <h2 class="mb-4">Order Statistics</h2>

      <form id="orderStatsForm" action="{{route('merchant.order-stats')}}" method="GET">
        <div class="row g-3">
          <div class="col-md-4">
            <label for="from_date" class="form-label">From Date:</label>
            <input
              type="date"
              id="from_date"
              name="from"
              class="form-control"
              required
            />
          </div>
          <div class="col-md-4">
            <label for="to_date" class="form-label">To Date:</label>
            <input
              type="date"
              id="to_date"
              name="to"
              class="form-control"
              required
            />
          </div>
          <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
              Get Stats
            </button>
          </div>
        </div>
      </form>

    </div>

    <!-- Bootstrap JS CDN (Optional, for features like modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
