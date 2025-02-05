# task 2

* Explain how to automate deployments via a deployment script or continuous integration pipeline.

## scripted deployments

### background 

Recently I've been using Jenkins for deployment of Eventfinda apps to AWS. We've got a jenkins server running alongside our app servers.

The jenkins scripts have been around since the days of having Eventfinda running on bare metal servers in a local data center,
and the apps have been lifted-and-shifted over to EC2 instances.

The overall infra is based in AWS Sydney, with DR failover in West Coast USA IIRC. It is set up with an ALB via Cloudflare and AWS WAF.

All the EC2 app servers run in ASGs, from 1 - 8 servers depending on load. When a massive load is expected, ie when a big ticket release happens,
we'll manually pre-scale up to the max to cater for the expected demand.

DBs are on RDS, MySQL for most of the apps, plus DynamoDB to handle queuing for the custom mailing lists.

CDN nodes are on S3 serving images, js etc.

### scripting

We've got a number of bash scripts to run app deployments that are manually triggered with Jenkins.

The workflow goes like this

* in bitbucket, do manual code merge to main git branch
* login to jenkins
* spin up fresh deployment staging EC2 servers
* run main deployment script which does the following

1. wait for staging instance
2. git pull main branch changes (jenkins is set up with an ssh key to read from git)
3. run composer install, npm install etc
4. pull any artefact changes
5. run JS compilation scripts (eslint, babel etc)
6. run migrations against staging database clone
7. when its all ready, spin up replacement production EC2 instances
8. rsync code to each production instance
9. rsync artefacts to S3 / CDN cluster, and update cache-busting value
10. run migrations, smoketests / healthchecks on new production instances
11. shutdown each old instance when ready
12. clean up and shutdown staging instance
13. check nothing broke...

### ci / cd

At Figured we had gitlab set up with a really slick set of pipelines. I can give a basic overview but I didn't work on much of it myself.

1. PR is approved by peer reviewers
2. dev triggers test pipeline against their branch, running the full test suite, including
 - linting
 - license checks
 - merge approval checks
 - code coverage report
 - unit tests
 - feature / e2e tests, grouped across parallel gitlab workers
3. when pipeline passes, run deployment steps. We were on AWS but I don't recall what the specifics were.
4. deployment runs, manual smoketests are run, and some slack hooks give us applause or boos depending on how it went.

If I had my choice at ImpactLab I'd go for a modern CI/CD set up like that, with as much risk removed as possible, allowing rapid safe deployments
where devs can have ownership of their changes right through to production.
