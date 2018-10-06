#include<cstdio>

long long s=0, t=0, pre_t=0, u=1e12;
long a[33], v=0;
int n;

long long abs(long long n)
{
    if (n>=0) return n; return -n;
}

void update(long long p)
{
    if (abs(s-2*p)<u)
    {
        u=abs(s-2*p);
        v=0;
    }
    if (abs(s-2*p)<=u) ++v;
}

void divide(int j, int p)
{
    if (2*t>s)
    {
        update(t);
        update(pre_t);
    }
    else
    for (int i=p; i<=n; ++i)
    {
        pre_t=t;
        t+=a[i];
        if (j<n/2) divide(j+1, i+1);
        else update(t);
        t-=a[i];
    }
}

int main()
{
    scanf("%d", &n);
    for (int i=1; i<=n; ++i) scanf("%ld", a+i);
    for (int i=1; i<=n; ++i) s+=a[i];
    divide(1, 1);
    if (!u) v/=2;
    printf("%lld %ld", u, v);
    return 0;
}
